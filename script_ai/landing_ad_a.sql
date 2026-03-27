-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Мар 25 2026 г., 08:11
-- Версия сервера: 8.0.45-0ubuntu0.24.04.1
-- Версия PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `landing_ad_a`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-cadf1c29a877eb512860892cc17fd6fc', 'i:2;', 1774425815),
('laravel-cache-cadf1c29a877eb512860892cc17fd6fc:timer', 'i:1774425815;', 1774425815);

-- --------------------------------------------------------

--
-- Структура таблицы `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `custom_pages`
--

CREATE TABLE `custom_pages` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `custom_pages`
--

INSERT INTO `custom_pages` (`id`, `title`, `slug`, `icon`, `content`, `is_published`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Согласие на обработку персональных данных', 'privacy', 'icon-about-shield', '<h3>1. Общие положения</h3><p>Настоящее Согласие на обработку персональных данных (далее — Согласие) составлено в соответствии с требованиями Федерального закона от 27.07.2006 №152-ФЗ «О персональных данных» и определяет порядок обработки персональных данных и меры по обеспечению безопасности персональных данных, предпринимаемые компанией «Авто Доставка» (далее — Оператор).Используя веб-сайт и/или отправляя свои персональные данные через формы обратной связи, вы даете согласие на обработку своих персональных данных в соответствии с условиями, изложенными в настоящем документе.</p><h3>2. Перечень обрабатываемых персональных данных</h3><p>Оператор может осуществлять обработку следующих персональных данных:</p><ul><li><p>Фамилия, имя, отчество</p></li><li><p>Номер телефона</p></li><li><p>Адрес электронной почты</p></li><li><p>Название организации</p></li><li><p>Должность</p></li><li><p>Информация о грузе и маршруте доставки</p></li></ul><h3><br>3. Цели обработки персональных данных</h3><p>Персональные данные обрабатываются Оператором в следующих целях:</p><ul><li><p>Предоставление информации об услугах компании</p></li><li><p>Обработка запросов и заявок на расчет стоимости доставки</p></li><li><p>Заключение и исполнение договоров на оказание транспортно-логистических услуг</p></li><li><p>Связь с клиентами по вопросам оказания услуг</p></li><li><p>Информирование о статусе доставки грузов</p></li><li><p>Улучшение качества обслуживания клиентов</p></li><li><p>Проведение маркетинговых исследований</p></li></ul><h3><br>4. Правовые основания обработки персональных данных</h3><p>Оператор обрабатывает персональные данные на следующих правовых основаниях:Согласие субъекта персональных данных на обработку его персональных данных<br>Исполнение договора, стороной которого является субъект персональных данных<br>Федеральный закон от 27.07.2006 №152-ФЗ «О персональных данных»</p><h3><br>5. Порядок и условия обработки персональных данных</h3><p>Обработка персональных данных осуществляется Оператором с соблюдением следующих условий:</p><ul><li><p>Обработка осуществляется с использованием средств автоматизации и без использования таких средств</p></li><li><p>Персональные данные хранятся в форме, позволяющей определить субъекта персональных данных, не дольше, чем этого требуют цели их обработки</p></li><li><p>Обработка производится с соблюдением принципов законности и справедливости</p></li><li><p>Обеспечивается точность персональных данных, их достаточность и актуальность</p></li></ul><h3><br>6. Меры по защите персональных данных</h3><p>Оператор принимает необходимые и достаточные правовые, организационные и технические меры для защиты персональных данных от неправомерного или случайного доступа к ним, уничтожения, изменения, блокирования, копирования, распространения, а также от иных неправомерных действий:Назначение лица, ответственного за обработку персональных данных<br>Ограничение доступа к персональным данным<br>Применение организационных и технических мер защиты информации<br>Использование средств защиты информации, прошедших процедуру оценки соответствия<br>Обучение сотрудников, осуществляющих обработку персональных данных</p><h3><br>7. Права субъекта персональных данных</h3><p>В соответствии со статьей 14 Федерального закона №152-ФЗ субъект персональных данных имеет право:</p><ul><li><p>Получать информацию, касающуюся обработки его персональных данных</p></li><li><p>Требовать уточнения своих персональных данных, их блокирования или уничтожения</p></li><li><p>Отозвать согласие на обработку персональных данных</p></li><li><p>Обжаловать действия или бездействие Оператора в уполномоченный орган по защите прав субъектов персональных данных или в судебном порядке</p></li><li><p>Получать информацию о сроках обработки персональных данных</p></li></ul><h3><br>8. Передача персональных данных третьим лицам</h3><p>Оператор не передает персональные данные третьим лицам, за исключением следующих случаев:</p><ul><li><p>Субъект персональных данных явно выразил свое согласие на такие действия<br>Передача необходима для исполнения договора с субъектом персональных данных<br>Передача предусмотрена российским или иным применимым законодательством<br>Передача осуществляется партнерам Оператора для исполнения обязательств перед субъектом персональных данных</p></li></ul><h3><br>9. Трансграничная передача персональных данных</h3><p>До начала осуществления трансграничной передачи персональных данных Оператор обязан убедиться в том, что иностранным государством, на территорию которого предполагается осуществлять передачу персональных данных, обеспечивается адекватная защита прав субъектов персональных данных.</p><h3>10. Срок действия согласия</h3><p>Настоящее согласие действует с момента предоставления персональных данных и до момента его отзыва субъектом персональных данных. Согласие может быть отозвано субъектом персональных данных путем направления письменного заявления Оператору по адресу электронной почты:st_air@mail.ru</p><h3>11. Контактная информация</h3><p>Оператор персональных данных: Авто Доставка</p><ul><li><p>Электронная почта: <a target=\"_blank\" rel=\"noopener noreferrer nofollow\" href=\"mailto:st_air@mail.ru\">st_air@mail.ru</a></p></li><li><p>Телефон: +7 912 280 51 38</p></li><li><p>Telegram: @sss_air</p></li></ul><h3>12. Заключительные положения</h3><p>Оператор имеет право вносить изменения в настоящее Согласие. При внесении изменений в заголовке документа указывается дата последнего обновления. Новая редакция Согласия вступает в силу с момента ее размещения на сайте.</p><p>Действующая редакция Согласия постоянно доступна на странице по адресу: /privacy</p>', 1, 0, '2026-03-10 12:59:35', '2026-03-10 12:59:35');

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `landing_sections`
--

CREATE TABLE `landing_sections` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` text COLLATE utf8mb4_unicode_ci,
  `background_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `landing_sections`
--

INSERT INTO `landing_sections` (`id`, `code`, `title`, `subtitle`, `background_image`, `meta`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'hero', 'Надежные грузоперевозки по России и СНГ', 'Срочные доставки. Сложные маршруты. Международная логистика.', 'landing-sections/backgrounds/01KKBW6A3PRHH0TA5DG6W6PC14.png', '{\"primary_button_url\": \"#\", \"primary_button_text\": \"Получить расчет\", \"secondary_button_url\": \"/tracking\", \"secondary_button_text\": \"Отследить груз\"}', 1, 10, '2026-03-10 12:16:02', '2026-03-10 12:40:17'),
(2, 'about', 'Кто мы', 'Компания «Авто Доставка» — это надежный партнер в сфере грузоперевозок', NULL, NULL, 1, 20, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(3, 'services', 'Что перевозим', 'Широкий спектр логистических решений для вашего бизнеса', NULL, NULL, 1, 30, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(4, 'advantages', 'Преимущества работы с нами', NULL, NULL, NULL, 1, 40, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(5, 'steps', 'Как работаем', NULL, NULL, NULL, 1, 50, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(6, 'stats', 'Почему выбирают нас', 'Цифры и факты, которые говорят сами за себя', NULL, NULL, 1, 60, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(7, 'mission', 'Наша миссия', 'Оставаться надежным и ответственным поставщиком автотранспортных услуг.', 'landing-sections/backgrounds/01KKBW88X3XNJMS4YSNZ6SWDNC.png', '{\"accent_text\": \"Нести пользу, доставляя решения!\"}', 1, 70, '2026-03-10 12:16:02', '2026-03-10 12:41:21'),
(8, 'clients', 'Нам доверяют', 'Наши клиенты — это наша гордость', NULL, NULL, 1, 80, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(9, 'geography_countries', 'География перевозок', 'Мы работаем по всей России и международным направлениям', NULL, NULL, 1, 90, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(10, 'geography_routes', 'Примеры маршрутов', NULL, NULL, NULL, 1, 91, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(11, 'cta', 'Рассчитаем доставку под ваш маршрут', 'Получите индивидуальное предложение с учетом всех особенностей вашего груза', NULL, '{\"button_url\": \"#\", \"button_text\": \"Получить расчет\"}', 1, 100, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(12, 'footer_navigation', 'Навигация', NULL, NULL, NULL, 1, 110, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(13, 'footer_contacts', 'Контакты', NULL, NULL, NULL, 1, 120, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(14, 'footer_services', 'Услуги', NULL, NULL, NULL, 1, 130, '2026-03-10 12:16:02', '2026-03-10 12:16:02');

-- --------------------------------------------------------

--
-- Структура таблицы `landing_section_items`
--

CREATE TABLE `landing_section_items` (
  `id` bigint UNSIGNED NOT NULL,
  `section_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `badge` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `landing_section_items`
--

INSERT INTO `landing_section_items` (`id`, `section_id`, `title`, `description`, `image_url`, `badge`, `meta`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 2, 'На рынке с 2018 года', '6+ лет успешной работы в сфере логистики', NULL, NULL, NULL, 1, 1, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(2, 2, 'Россия, Китай, Турция, Казахстан', 'Международная логистика и внутренние перевозки', NULL, NULL, NULL, 1, 2, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(3, 2, 'Контроль 24/7', 'Страхование каждого груза и полная ответственность', NULL, NULL, NULL, 1, 3, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(4, 2, 'Подбор транспорта за 1–3 дня', 'Быстрый старт и оперативная доставка', NULL, NULL, NULL, 1, 4, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(5, 3, 'Сборные грузы', 'Экономичная доставка для небольших партий товаров', NULL, NULL, NULL, 1, 1, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(6, 3, 'Опасные и негабаритные', 'Специализированная перевозка сложных грузов', NULL, NULL, NULL, 1, 2, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(7, 3, 'Промышленное оборудование', 'Профессиональная доставка тяжелой техники', NULL, NULL, NULL, 1, 3, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(8, 3, 'Таможенное оформление и СВХ', 'Полный комплекс услуг по таможенному сопровождению', NULL, NULL, NULL, 1, 4, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(9, 4, 'Персональный менеджер', 'Индивидуальный подход к каждому клиенту', NULL, NULL, NULL, 1, 1, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(10, 4, 'Страхование ответственности', 'Гарантия сохранности вашего груза', NULL, NULL, NULL, 1, 2, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(11, 5, '1. Подбор транспорта', 'Подбираем оптимальный вариант за 1–3 дня', NULL, NULL, NULL, 1, 1, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(12, 5, '2. Доставка из Китая', 'Проверенные маршруты и надежные партнеры', NULL, NULL, NULL, 1, 2, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(13, 5, '3. Прозрачная стоимость', 'Без скрытых платежей и дополнительных сборов', NULL, NULL, NULL, 1, 3, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(14, 6, '6+', 'лет на рынке', NULL, NULL, NULL, 1, 1, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(15, 6, '1000+', 'доставок', NULL, NULL, NULL, 1, 2, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(16, 6, '25', 'сотрудников', NULL, NULL, NULL, 1, 3, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(17, 6, '15', 'опытных водителей', NULL, NULL, NULL, 1, 4, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(18, 6, '100%', 'работа по договору', NULL, NULL, NULL, 1, 5, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(19, 8, 'ZUBK.NET', 'Доставка металлоконструкций', NULL, NULL, NULL, 1, 1, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(20, 8, 'PermMetall', 'Регулярная логистика по России', NULL, NULL, NULL, 1, 2, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(21, 8, 'ПСК БТ', 'Логистика стройматериалов', NULL, NULL, NULL, 1, 3, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(22, 9, 'Россия', 'Вся территория РФ', NULL, NULL, NULL, 1, 1, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(23, 9, 'Китай', 'Основные направления', NULL, NULL, NULL, 1, 2, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(24, 9, 'Турция', 'Регулярные рейсы', NULL, NULL, NULL, 1, 3, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(25, 9, 'Казахстан', 'Приграничная логистика', NULL, NULL, NULL, 1, 4, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(26, 10, 'Китай → Новосибирск', NULL, NULL, '17 дней', NULL, 1, 1, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(27, 10, 'Турция → Москва', NULL, NULL, '10–12 дней', NULL, 1, 2, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(28, 10, 'Казахстан → Екатеринбург', NULL, NULL, '5–7 дней', NULL, 1, 3, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(29, 12, 'Главная', NULL, NULL, NULL, '{\"url\": \"/#hero\"}', 1, 1, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(30, 12, 'Услуги', NULL, NULL, NULL, '{\"url\": \"/#services\"}', 1, 2, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(31, 12, 'О нас', NULL, NULL, NULL, '{\"url\": \"/#about\"}', 1, 3, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(32, 13, '+7 912 280 51 38', NULL, NULL, NULL, '{\"url\": \"tel:+79122805138\"}', 1, 1, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(33, 13, 'st_air@mail.ru', NULL, NULL, NULL, '{\"url\": \"mailto:st_air@mail.ru\"}', 1, 2, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(34, 14, 'Сборные грузы', NULL, NULL, NULL, NULL, 1, 1, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(35, 14, 'Негабаритные перевозки', NULL, NULL, NULL, NULL, 1, 2, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(36, 14, 'Таможенное оформление', NULL, NULL, NULL, NULL, 1, 3, '2026-03-10 12:16:02', '2026-03-10 12:16:02');

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_10_000001_create_quote_requests_table', 1),
(5, '2026_03_10_000002_create_shipments_table', 1),
(6, '2026_03_10_000003_create_shipment_statuses_table', 1),
(7, '2026_03_10_000004_create_landing_sections_table', 1),
(8, '2026_03_10_000005_create_landing_section_items_table', 1),
(9, '2026_03_10_000006_create_site_settings_table', 1),
(10, '2026_03_10_000007_create_custom_pages_table', 1),
(11, '2026_03_10_000008_add_icon_to_custom_pages_table', 1),
(12, '2026_03_11_000009_create_tracking_requests_table', 2),
(13, '2026_03_24_000010_create_tracking_shipments_table', 3),
(14, '2026_03_24_000011_create_tracking_events_table', 3),
(15, '2026_03_24_000012_drop_legacy_shipments_tables', 3),
(16, '2026_03_24_000013_drop_tracking_shipments_table', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `quote_requests`
--

CREATE TABLE `quote_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cargo_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `consent` tinyint(1) NOT NULL DEFAULT '0',
  `source_page` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('3tdGJZSopPab4ig5S2Vn0X2Nwwqz7LLdr2itGfuL', NULL, '85.239.57.126', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoickFPajN4OHRYZnpKTVpJM21GNm82Q2dzN256ckJtT24xUjFwU1ZScSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vbGFuZGluZy1hZC5heGVjb2RlLnRlY2giO3M6NToicm91dGUiO3M6Mjc6ImdlbmVyYXRlZDo6b1FveDlGelRzTHB1enV6bCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774421767),
('56tbgHP2IVAc4TK4hCuF8zUUfZjTOvpEzPoAwMUz', NULL, '85.239.57.126', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicmJFY25ieWU3aTl6Z2FMM29wd25KRmhHZENUZXFzaGxITnBUQkF3WCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vbGFuZGluZy1hZC5heGVjb2RlLnRlY2giO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774416486),
('5kSNTZdxY7urrXbJAfjWZXfUXCAMXZR1X1LBQTuG', NULL, '85.239.57.126', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV1RDNEl6MUt0cEhoZm1RVUJEQm45S0U4U09ONUVpdWxGRTFaOXRnZSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vbGFuZGluZy1hZC5heGVjb2RlLnRlY2giO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774415647),
('8AapeLcYWlCDhfHKtukughnEAADlNqaA9Eu2baLt', NULL, '85.239.57.126', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicWcxWFZ2UmY0WmRIM0xvaXVZYVZpSVJQOXIzaWZmNDlBSG5UeVRWQiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vbGFuZGluZy1hZC5heGVjb2RlLnRlY2giO3M6NToicm91dGUiO3M6Mjc6ImdlbmVyYXRlZDo6SVdzU2tuMktxcDEwOGpkNiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774422008),
('adsrKchVkM2zUSEvOunf8WM7vz6ubahocmmVXO0k', NULL, '85.239.57.126', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTDlJR0psSk04bnhESWp3aG00VkNDbGhaOVY0RnI1Q0Rha25OSklDaCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vbGFuZGluZy1hZC5heGVjb2RlLnRlY2giO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774414808),
('cnM6RLqxFeiilqX1X3lEsYEgNMJmzTldeGe43jKy', NULL, '164.92.131.10', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibU01SmhqdGxCb1FkMEphZjNRSWhLZlhHSHdnTmlJaVdUd2VFRGdSTSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vbGFuZGluZy1hZC5heGVjb2RlLnRlY2giO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774419499),
('DfLNOf0MCAvs8BO09bIx2vPi3HfZcfgj6yQZZONc', NULL, '85.239.57.126', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWEhKZzZrMUNLNjVWT09SMnpsdUF5RDVHZUtoSnJXVkg1bUp2UE12ZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vbGFuZGluZy1hZC5heGVjb2RlLnRlY2giO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774418408),
('dR5SMtyHg4K9a0FlSKyfwv4WOaPuuv4GQLmSE6pT', NULL, '93.123.109.214', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOUQ4ek5RRWwyRk5vYnNpcGlUWVliQzZzaHU5QTNxRUNQbXlOY0lPVCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vd3d3LmxhbmRpbmctYWQuYXhlY29kZS50ZWNoIjtzOjU6InJvdXRlIjtzOjI3OiJnZW5lcmF0ZWQ6OjNOdUw3YnpRMWVhTm1ZZnYiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774422899),
('EiiKX26ZIQBVYyMQ2XWbUG3aCS0Zht98vuuSXasO', NULL, '85.239.57.126', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQzJla2ExcnFqS1YwaFdYTkpHSU13dlpFRXc2aFpIMVpXc3JzUFg3ciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vbGFuZGluZy1hZC5heGVjb2RlLnRlY2giO3M6NToicm91dGUiO3M6Mjc6ImdlbmVyYXRlZDo6M051TDdielExZWFObVlmdiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774422848),
('gWdoG1PpFpVMQ6aHKZnJwj0ge1R9ekgbttzLEz74', NULL, '45.144.49.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN2FkVHQxSTRTU1U0QkZMSGlYT0o2TWxicHBNUjQ1aGpLbHFIU2FpUSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHBzOi8vbGFuZGluZy1hZC5heGVjb2RlLnRlY2gvdHJhY2tpbmciO3M6NToicm91dGUiO3M6ODoidHJhY2tpbmciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774421437),
('JYcf29YnYcgQ4fmB8IB3d5MIFnLSmDTbFYKwxoDi', NULL, '85.239.57.126', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQnFmSGxlWjRvN1VNSXdsT3RCM1NNWWhWV0x6MnpQNUhmUHY5OUIxaCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vbGFuZGluZy1hZC5heGVjb2RlLnRlY2giO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774420086),
('K7Utmc22SRg1UDbcCSQ5xgAF3i6e6v0PgoKxnH9h', NULL, '45.144.49.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMnNQckVLYUNQVGVyNGh0UE1Cb3JXRjRocnl3VTFmZGRIUHVHUEc2SyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHBzOi8vbGFuZGluZy1hZC5heGVjb2RlLnRlY2gvdHJhY2tpbmciO3M6NToicm91dGUiO3M6ODoidHJhY2tpbmciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774425898),
('L0oDSDqhktig6b4HyJCzvG7c7yEQToQWifnBFipe', NULL, '85.239.57.126', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaWxjUzczd0NoVm94dmZ1SmhOcEQ5dzd2WlJtbHZyV0JUNjVKVUtETyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vbGFuZGluZy1hZC5heGVjb2RlLnRlY2giO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774417326),
('nlce3mtwGiZ27xCoNGXbPTEL1tYa2ZVE3KcEoGX8', NULL, '45.144.49.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaWZQbHo1b200V1NoSkJRZ0JVMlNJb2Q2aUtwNnJsMzlhNFlyRTJsWiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHBzOi8vbGFuZGluZy1hZC5heGVjb2RlLnRlY2gvdHJhY2tpbmciO3M6NToicm91dGUiO3M6ODoidHJhY2tpbmciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774421856),
('OTSBFXbnDIxi03ZjI38Zmc8H95frbsi3InrdtIhh', NULL, '85.239.57.126', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR2c5ejVwdDQwSnFOdVprZ3FoOEpUTUs0NnFVeXlBSzFxeEh1TTBkVyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vbGFuZGluZy1hZC5heGVjb2RlLnRlY2giO3M6NToicm91dGUiO3M6Mjc6ImdlbmVyYXRlZDo6M051TDdielExZWFObVlmdiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774424526),
('uaTNOhBhdqKsajk8uCYHre9r9zh18iRekvwk536n', NULL, '85.239.57.126', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN2NOM3hwZE93WHhOd0FXRVRvUkVQNVJTdUZxY2M2VkZDNlBnY0oyeCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vbGFuZGluZy1hZC5heGVjb2RlLnRlY2giO3M6NToicm91dGUiO3M6Mjc6ImdlbmVyYXRlZDo6M051TDdielExZWFObVlmdiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774425607),
('UrJOsCBaO4JArZb6qAWGABsitEZtSlyWOupWFJKE', NULL, '85.239.57.126', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSnF3NXdodWdrdkJNMTRkOGxDNm5NYzI4WWo4bTcwaG1KVm9yMlBlaiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vbGFuZGluZy1hZC5heGVjb2RlLnRlY2giO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774419246),
('xfdYcdVxjsToDeVqn3jHscAR8bEHaa14xKOSPFyc', NULL, '85.239.57.126', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQTNVdThNeTlWV29Zc3BKNFNuZThvcWh5MWdsb0NRbmRKMmRtQnlpdSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vbGFuZGluZy1hZC5heGVjb2RlLnRlY2giO3M6NToicm91dGUiO3M6Mjc6ImdlbmVyYXRlZDo6M051TDdielExZWFObVlmdiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774423686),
('xgAHfTbrrTnJ6gmfnJyzBUSwXw54eHDC9CQXkHEM', NULL, '93.123.109.214', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicUtEU0dWbXlDdlVQYW56bExCdUtvS0k1ZVJNaUJVOTZWN2E2S3JWayI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vd3d3LmxhbmRpbmctYWQuYXhlY29kZS50ZWNoIjtzOjU6InJvdXRlIjtzOjI3OiJnZW5lcmF0ZWQ6OjNOdUw3YnpRMWVhTm1ZZnYiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774422900),
('Xv1D8NbNIQZ49odNxKitUQL7YYJyYYH9XR0DGVSi', NULL, '85.239.57.126', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWWh1S21sVU5sUnk1dm9JTlRuVEhaQnVFdlF2Rm1XU1R5RjlWMFM0MSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vbGFuZGluZy1hZC5heGVjb2RlLnRlY2giO3M6NToicm91dGUiO3M6Mjc6ImdlbmVyYXRlZDo6M051TDdielExZWFObVlmdiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774425367),
('YJZHnmh7BcBKaRYinNvwvApAfeA1CbPjrBGhJZXF', NULL, '85.239.57.126', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib201TXJydjVleGxqdWY3dFlKVEpHYUdycjVRTHhhZGUyVERDTkRadCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vbGFuZGluZy1hZC5heGVjb2RlLnRlY2giO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774418166),
('YZ4MZSc6nwGS6gqgFLlG4zaU5IOzf1fQvyClPOoX', NULL, '85.239.57.126', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidm1CSDJSUjI3ODM1ek5vbWZkcERWYW1HOVFNN0RlSDRqYWQweFh6SyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vbGFuZGluZy1hZC5heGVjb2RlLnRlY2giO3M6NToicm91dGUiO3M6Mjc6ImdlbmVyYXRlZDo6Yll6NFd5TXV2bkZRcWxCNCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774420927);

-- --------------------------------------------------------

--
-- Структура таблицы `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `is_public` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `site_settings`
--

INSERT INTO `site_settings` (`id`, `key`, `value`, `is_public`, `created_at`, `updated_at`) VALUES
(1, 'site_logo', '<p>Авто Доставка</p>', 1, '2026-03-10 12:16:02', '2026-03-10 12:36:04'),
(2, 'site_name', 'Авто Доставка', 1, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(3, 'site_tagline', 'Надежные грузоперевозки по России и СНГ с 2018 года', 1, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(4, 'clients_trust_text', 'Более 100 довольных клиентов по всей России', 1, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(5, 'footer_copyright', '© 2026 Авто Доставка. Все права защищены.', 1, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(6, 'footer_geo_text', '<p><a target=\"_blank\" rel=\"noopener noreferrer nofollow\" href=\"/pages/privacy\">Политика конфидициальности</a></p>', 1, '2026-03-10 12:16:02', '2026-03-10 13:01:54'),
(7, 'contact_phone', '+7 912 280 51 38', 1, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(8, 'contact_email', 'st_air@mail.ru', 1, '2026-03-10 12:16:02', '2026-03-10 12:16:02'),
(9, 'contact_telegram_url', 'https://t.me/sss_air', 1, '2026-03-10 12:16:02', '2026-03-10 12:16:02');

-- --------------------------------------------------------

--
-- Структура таблицы `tracking_events`
--

CREATE TABLE `tracking_events` (
  `id` bigint UNSIGNED NOT NULL,
  `event_uid` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tracking_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_type` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `occurred_at` datetime NOT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `source_system` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `received_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `tracking_events`
--

INSERT INTO `tracking_events` (`id`, `event_uid`, `tracking_number`, `event_type`, `status`, `occurred_at`, `latitude`, `longitude`, `notes`, `source_system`, `received_at`, `created_at`, `updated_at`) VALUES
(1, 'trip_event_43', 'TRK-8BTC-CAJ3', 'departed', 'in_transit', '2026-03-25 07:55:53', NULL, NULL, 'prod runtime check after secret sync 2026-03-25 07:55:53', 'avtodostavka-main', '2026-03-25 07:55:54', '2026-03-25 07:55:54', '2026-03-25 07:55:54'),
(2, 'trip_event_39', 'TRK-8BTC-CAJ3', 'departed', 'in_transit', '2026-03-25 07:41:04', NULL, NULL, NULL, 'avtodostavka-main', '2026-03-25 07:56:00', '2026-03-25 07:56:00', '2026-03-25 07:56:00'),
(3, 'trip_event_41', 'TRK-8BTC-CAJ3', 'loading_started', 'loading', '2026-03-25 07:48:30', NULL, NULL, NULL, 'avtodostavka-main', '2026-03-25 07:56:00', '2026-03-25 07:56:00', '2026-03-25 07:56:00'),
(4, 'trip_event_44', 'TRK-63LL-8L6R', 'departed', 'in_transit', '2026-03-25 08:02:34', NULL, NULL, NULL, 'avtodostavka-main', '2026-03-25 08:02:35', '2026-03-25 08:02:35', '2026-03-25 08:02:35'),
(5, 'trip_event_45', 'TRK-63LL-8L6R', 'loading_started', 'loading', '2026-03-25 08:02:50', NULL, NULL, NULL, 'avtodostavka-main', '2026-03-25 08:02:51', '2026-03-25 08:02:51', '2026-03-25 08:02:51');

-- --------------------------------------------------------

--
-- Структура таблицы `tracking_requests`
--

CREATE TABLE `tracking_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `search_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_found` tinyint(1) NOT NULL DEFAULT '0',
  `source_page` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `tracking_requests`
--

INSERT INTO `tracking_requests` (`id`, `search_code`, `is_found`, `source_page`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 'TRK001', 1, 'https://landing-ad.axecode.tech/tracking?code=TRK001', '45.144.49.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-19 11:37:16', '2026-03-19 11:37:16'),
(2, 'TRK001', 1, 'https://landing-ad.axecode.tech/tracking?code=TRK001', '45.144.49.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-19 11:37:20', '2026-03-19 11:37:20'),
(3, 'TRK001', 1, 'https://landing-ad.axecode.tech/tracking?code=TRK001', '45.144.49.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-19 11:37:25', '2026-03-19 11:37:25'),
(4, 'TRK-8BTC-CAJ3', 0, 'https://landing-ad.axecode.tech/tracking?code=TRK-8BTC-CAJ3', '45.144.49.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-25 07:40:56', '2026-03-25 07:40:56'),
(5, 'TRK-8BTC-CAJ3', 0, 'https://landing-ad.axecode.tech/tracking?tracking_number=TRK-8BTC-CAJ3', '45.144.49.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-25 07:41:00', '2026-03-25 07:41:00'),
(6, 'TRK-8BTC-CAJ3', 0, 'https://landing-ad.axecode.tech/tracking?tracking_number=TRK-8BTC-CAJ3', '45.144.49.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-25 07:41:01', '2026-03-25 07:41:01'),
(7, 'TRK-8BTC-CAJ3', 0, 'https://landing-ad.axecode.tech/tracking?tracking_number=TRK-8BTC-CAJ3', '45.144.49.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-25 07:41:09', '2026-03-25 07:41:09'),
(8, 'TRK-8BTC-CAJ3', 0, 'https://landing-ad.axecode.tech/tracking?tracking_number=TRK-8BTC-CAJ3', '45.144.49.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-25 07:41:10', '2026-03-25 07:41:10'),
(9, 'TRK-8BTC-CAJ3', 0, 'https://landing-ad.axecode.tech/tracking?tracking_number=TRK-8BTC-CAJ3', '45.144.49.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-25 07:41:11', '2026-03-25 07:41:11'),
(10, 'TRK-8BTC-CAJ3', 1, 'https://landing-ad.axecode.tech/tracking?tracking_number=TRK-8BTC-CAJ3', '45.144.49.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-25 08:00:37', '2026-03-25 08:00:37'),
(11, 'TRK-63LL-8L6R', 0, 'https://landing-ad.axecode.tech/tracking?tracking_number=TRK-63LL-8L6R', '45.144.49.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-25 08:02:31', '2026-03-25 08:02:31'),
(12, 'TRK-63LL-8L6R', 1, 'https://landing-ad.axecode.tech/tracking?tracking_number=TRK-63LL-8L6R', '45.144.49.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-25 08:02:37', '2026-03-25 08:02:37'),
(13, 'TRK-63LL-8L6R', 1, 'https://landing-ad.axecode.tech/tracking?tracking_number=TRK-63LL-8L6R', '45.144.49.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-25 08:02:56', '2026-03-25 08:02:56');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', NULL, '$2y$12$2tCLYGP3BPrCsTZ6B4do6O9vJ1iFEdk1uPwc9IekqrVHEXDqoklzi', NULL, '2026-03-10 12:16:01', '2026-03-10 12:16:01'),
(2, 'Admin', 'admin@avtodostavka.su', NULL, '$2y$12$VujAvOoyRlRTEIo/SIagVORsawfDNabefGdmv39sYPsMRE32lyWyS', '866f0ON3dFIWtP0JLDG9VwKlo1ffWV0QCz5bA9WyTehnhlb2FcFGyXxOCNYo', '2026-03-10 12:21:58', '2026-03-10 12:21:58');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Индексы таблицы `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Индексы таблицы `custom_pages`
--
ALTER TABLE `custom_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `custom_pages_slug_unique` (`slug`),
  ADD KEY `custom_pages_is_published_sort_order_index` (`is_published`,`sort_order`);

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Индексы таблицы `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Индексы таблицы `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `landing_sections`
--
ALTER TABLE `landing_sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `landing_sections_code_unique` (`code`),
  ADD KEY `landing_sections_is_active_sort_order_index` (`is_active`,`sort_order`);

--
-- Индексы таблицы `landing_section_items`
--
ALTER TABLE `landing_section_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `landing_section_items_section_id_is_active_sort_order_index` (`section_id`,`is_active`,`sort_order`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Индексы таблицы `quote_requests`
--
ALTER TABLE `quote_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quote_requests_status_index` (`status`);

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Индексы таблицы `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `site_settings_key_unique` (`key`);

--
-- Индексы таблицы `tracking_events`
--
ALTER TABLE `tracking_events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tracking_events_event_uid_unique` (`event_uid`),
  ADD KEY `tracking_events_tracking_number_occurred_at_index` (`tracking_number`,`occurred_at`),
  ADD KEY `tracking_events_tracking_number_id_index` (`tracking_number`,`id`);

--
-- Индексы таблицы `tracking_requests`
--
ALTER TABLE `tracking_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tracking_requests_search_code_index` (`search_code`),
  ADD KEY `tracking_requests_is_found_index` (`is_found`),
  ADD KEY `tracking_requests_created_at_index` (`created_at`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `custom_pages`
--
ALTER TABLE `custom_pages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `landing_sections`
--
ALTER TABLE `landing_sections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `landing_section_items`
--
ALTER TABLE `landing_section_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `quote_requests`
--
ALTER TABLE `quote_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `tracking_events`
--
ALTER TABLE `tracking_events`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `tracking_requests`
--
ALTER TABLE `tracking_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `landing_section_items`
--
ALTER TABLE `landing_section_items`
  ADD CONSTRAINT `landing_section_items_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `landing_sections` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
