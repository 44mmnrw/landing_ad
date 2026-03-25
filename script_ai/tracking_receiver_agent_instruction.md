# Инструкция для агента на втором сайте: прием и публикация трекинга перевозки

## Цель
Реализовать на втором сайте безопасный прием статусов перевозки из рабочей системы и публикацию трекинга во внешний интернет.

Второй сайт выступает как "буфер/витрина":
- принимает события только от доверенного источника (нашей рабочей системы),
- хранит их в своей БД,
- отдает публичный read-only API/страницы трекинга клиентам.

## Входные данные от источника
Источник отправляет события рейса с полями:
- `tracking_number` (пример: `TRK-7K4M-Q9T2`)
- `event_uid` (уникальный id события для идемпотентности)
- `event_type` (`loading_started`, `loading_done`, `departed`, `arrived`, `unloading_started`, `unloading_done`)
- `status` (`loading`, `in_transit`, `unloading`, `completed`)
- `occurred_at` (UTC ISO8601)
- `latitude` (nullable)
- `longitude` (nullable)
- `notes` (nullable)
- `source_system` (строка-идентификатор отправителя)
- `sent_at` (UTC ISO8601)

## Задача агента
Сделать серверную реализацию на втором сайте по шагам ниже.

---

## 1. Создать структуру БД

### 1.1 Таблица отправлений (агрегат текущего состояния)
Создать таблицу `tracking_shipments`:
- `id` bigint PK
- `tracking_number` varchar(20) NOT NULL UNIQUE
- `current_status` varchar(32) NOT NULL DEFAULT 'assigned'
- `last_event_type` varchar(32) NULL
- `last_event_at` datetime/timestamp NULL (UTC)
- `last_latitude` decimal(10,7) NULL
- `last_longitude` decimal(10,7) NULL
- `last_notes` text NULL
- `created_at`, `updated_at`

Индексы:
- UNIQUE (`tracking_number`)
- INDEX (`current_status`, `last_event_at`)

### 1.2 Таблица событий (история)
Создать таблицу `tracking_events`:
- `id` bigint PK
- `event_uid` varchar(100) NOT NULL UNIQUE
- `tracking_number` varchar(20) NOT NULL
- `event_type` varchar(32) NOT NULL
- `status` varchar(32) NOT NULL
- `occurred_at` datetime/timestamp NOT NULL (UTC)
- `latitude` decimal(10,7) NULL
- `longitude` decimal(10,7) NULL
- `notes` text NULL
- `source_system` varchar(64) NOT NULL
- `received_at` datetime/timestamp NOT NULL
- `created_at`, `updated_at`

Индексы:
- UNIQUE (`event_uid`)
- INDEX (`tracking_number`, `occurred_at`)
- INDEX (`tracking_number`, `id`)

Связь:
- логическая связь по `tracking_number`.

---

## 2. Создать внутренний endpoint приема событий

Создать endpoint:
- `POST /api/internal/tracking/events`

Требования:
- доступ только сервер-сервер,
- endpoint не должен быть публичным для клиентов,
- строгая валидация входного JSON.

### 2.1 Валидация
Проверять:
- `tracking_number`: required, regex `^TRK-[A-Z2-9]{4}-[A-Z2-9]{4}$`
- `event_uid`: required, string, max 100
- `event_type`: required, enum
- `status`: required, enum
- `occurred_at`: required, datetime
- `latitude`: nullable, numeric, range -90..90
- `longitude`: nullable, numeric, range -180..180
- `notes`: nullable, string
- `source_system`: required, string
- `sent_at`: required, datetime

### 2.2 Идемпотентность
Обязательное правило:
- если `event_uid` уже существует, вернуть `200 OK` с признаком `duplicate=true`,
- не создавать дубль и не считать это ошибкой.

### 2.3 Транзакция записи
В одной транзакции:
1. Insert в `tracking_events` (если `event_uid` новый).
2. Upsert `tracking_shipments` по `tracking_number`.
3. Обновить агрегат (`current_status`, `last_event_at`, координаты и т.д.) только если событие новее текущего:
   - сравнивать `occurred_at` с `last_event_at`.

---

## 3. Безопасность приема

Реализовать обязательно:
- HTTPS only.
- Подпись запроса HMAC SHA-256:
  - заголовки: `X-Signature`, `X-Timestamp`.
  - сигнатура считается по `timestamp + raw_body`.
  - секрет хранится в `.env`.
- Проверка времени запроса (например, окно 5 минут).
- IP allowlist для источника (если инфраструктура позволяет).
- Rate limit на внутренний endpoint.
- Логирование отказов аутентификации и невалидных payload.

---

## 4. Публичный API для клиентов (read-only)

Создать endpoint:
- `GET /api/public/tracking/{tracking_number}`

Возвращать:
- `tracking_number`
- `current_status`
- `last_event_at`
- последние N событий (например, 20) из `tracking_events` по `occurred_at desc`
- при необходимости: последнее местоположение

Важно:
- никаких внутренних полей безопасности (`event_uid`, подписи, source secret)
- никаких данных из основной рабочей БД.

---

## 5. Статусы и маппинг

Использовать единый словарь:
- `loading_started` -> `loading`
- `loading_done` -> `in_transit`
- `departed` -> `in_transit`
- `arrived` -> `in_transit`
- `unloading_started` -> `unloading`
- `unloading_done` -> `completed`

Если придет неизвестный `event_type`:
- сохранить событие как есть (если нужно для диагностики),
- не ломать endpoint,
- вернуть предупреждение в лог.

---

## 6. Онлайн-режим обновления

Минимально:
- после приема события данные сразу доступны через `GET /api/public/tracking/{tracking_number}`.

Опционально для UI:
- клиентский polling каждые 5-10 секунд,
- или websocket/SSE для push-обновлений.

---

## 7. Набор тестов (обязательно)

Реализовать тесты на:
1. Успешный прием валидного события.
2. Повторный прием того же `event_uid` (идемпотентность).
3. Некорректная подпись HMAC -> 401/403.
4. Старое событие не перетирает `last_event_at` и `current_status`.
5. Публичный endpoint возвращает агрегат + историю.

---

## 8. Что отдать по итогу

После реализации агент должен предоставить:
1. Список созданных/измененных файлов.
2. Миграции и схему таблиц.
3. Описание endpoint-ов (вход/выход, коды ответов).
4. Пример curl для внутреннего POST с HMAC.
5. Пример curl для публичного GET.
6. Результат запуска тестов.

---

## 9. Пример payload внутреннего POST

```json
{
  "tracking_number": "TRK-7K4M-Q9T2",
  "event_uid": "trip-128-event-455",
  "event_type": "loading_started",
  "status": "loading",
  "occurred_at": "2026-03-24T12:35:20Z",
  "latitude": 55.755826,
  "longitude": 37.6173,
  "notes": "Машина прибыла на склад",
  "source_system": "avtodostavka-main",
  "sent_at": "2026-03-24T12:35:21Z"
}
```

---

## 10. Ограничения

- Не делать прямых запросов из интернета в рабочую БД.
- Не хранить секреты в коде/репозитории.
- Все даты хранить в UTC.
- Любые ошибки приема не должны приводить к частичной записи в БД.
