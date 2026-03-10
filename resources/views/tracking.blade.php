<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Отследить груз — Авто Доставка</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="tracking-page">
@include('partials.header')

<main class="tracking-main-wrap">
    <section class="tracking-hero">
        <div class="tracking-icon-wrap">
            <img src="https://www.figma.com/api/mcp/asset/ce79365d-5e67-421b-8b9b-eb967f52aafd" alt="Иконка груза">
        </div>
        <h1>Отследить груз</h1>
        <p>Введите номер отслеживания для получения актуальной информации о местонахождении вашего груза</p>
    </section>

    <section class="tracking-search-card">
        <form class="tracking-form" autocomplete="off" method="get" action="{{ route('tracking') }}">
            <input id="trackingInput" name="code" type="text" value="{{ $searchCode }}" placeholder="TRK001" aria-label="Номер отслеживания">
            <button type="submit" class="tracking-search-btn">
                <img src="https://www.figma.com/api/mcp/asset/099fd5a6-5ffa-41aa-ab1a-7e7273f1b29f" alt="Поиск">
                Найти
            </button>
        </form>
        <p class="tracking-hint">Для демо используйте: TRK001, TRK002 или TRK003</p>
    </section>

    <section class="tracking-result-card" id="trackingCard">
        <div class="tracking-card-head">
            <div>
                <span>Номер отслеживания</span>
                <h2 id="trackCode">{{ $shipment?->code ?? ($searchCode ?: '—') }}</h2>
                <p class="tracking-route"><img src="https://www.figma.com/api/mcp/asset/62596046-6cb7-401b-ab03-5c08b1b18ece" alt="Маршрут"> <span id="trackRoute">{{ $shipment?->route ?? '—' }}</span></p>
            </div>
            <div class="tracking-cargo-meta">
                <span>Тип груза</span>
                <strong id="trackType">{{ $shipment?->cargo_type ?? '—' }}</strong>
                <small id="trackWeight">{{ $shipment?->weight_kg ? rtrim(rtrim(number_format((float) $shipment->weight_kg, 2, '.', ''), '0'), '.') . ' кг' : '—' }}</small>
            </div>
        </div>

        <div class="tracking-body">
            <h3>История статусов</h3>
            <div class="tracking-timeline" id="timeline">
                @if($shipment && $shipment->statuses->isNotEmpty())
                    @foreach($shipment->statuses as $status)
                        <div class="tracking-step {{ $status->is_done ? 'is-done' : 'is-pending' }}">
                            <div class="tracking-step-line {{ $loop->last ? 'is-last' : '' }}">
                                @if($status->is_done)
                                    <img src="https://www.figma.com/api/mcp/asset/628c5151-2ff6-4899-ab3a-90be616d8ee7" alt="Готово">
                                @else
                                    <span class="dot"></span>
                                @endif
                            </div>
                            <div class="tracking-step-card">
                                <div class="tracking-step-head">
                                    <h4>{{ $status->title }}</h4>
                                    <span>{{ $status->happened_at ? $status->happened_at->format('d.m.Y H:i') : '—' }}</span>
                                </div>
                                <p><img src="https://www.figma.com/api/mcp/asset/538d199c-5231-4d48-a206-a95881b37e4b" alt="Локация"> {{ $status->place ?: '—' }}</p>
                            </div>
                        </div>
                    @endforeach
                @elseif($searchedWithCode)
                    <div class="tracking-empty">Номер не найден. Используйте TRK001, TRK002 или TRK003.</div>
                @else
                    <div class="tracking-empty">Введите номер отслеживания и нажмите «Найти».</div>
                @endif
            </div>
        </div>

        <div class="tracking-footer-note">
            Возникли вопросы? Свяжитесь с нами по телефону
            <a href="tel:{{ preg_replace('/\D+/', '', $siteSettings['contact_phone'] ?? '+79122805138') }}">{{ $siteSettings['contact_phone'] ?? '+7 912 280 51 38' }}</a>
            или напишите на
            <a href="mailto:{{ $siteSettings['contact_email'] ?? 'st_air@mail.ru' }}">{{ $siteSettings['contact_email'] ?? 'st_air@mail.ru' }}</a>
        </div>
    </section>

    <a class="tracking-back-link" href="{{ url('/') }}">← Вернуться на главную</a>
</main>

@include('partials.footer')

@include('partials.calc-modal')
</body>
</html>
