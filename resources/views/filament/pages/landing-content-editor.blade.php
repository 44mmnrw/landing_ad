<x-filament-panels::page>
    <x-filament::section heading="Быстрый старт для контент-менеджера" description="Все основные действия в одном месте.">
        <div>
            <h3>1) Секции лендинга</h3>
            <p>Меняйте заголовки, подзаголовки, фоновые картинки и порядок блоков.</p>
            <p><a href="{{ route('filament.admin.resources.landing-sections.index') }}">Открыть секции лендинга</a></p>
        </div>

        <div style="margin-top: 14px;">
            <h3>2) Настройки сайта</h3>
            <p>Меняйте телефон, email, тексты футера, лого/название.</p>
            <p><a href="{{ route('filament.admin.resources.site-settings.index') }}">Открыть настройки сайта</a></p>
        </div>

        <div style="margin-top: 14px;">
            <h3>3) Карточки внутри секций</h3>
            <p>Карточки редактируются прямо внутри нужной секции (вкладка «Items»).</p>
        </div>
    </x-filament::section>

    <x-filament::section heading="Подсказка" description="Чтобы не ошибиться с контентом.">
        <ul>
            <li><b>Hero:</b> заголовок, подзаголовок, фон + кнопки в meta.</li>
            <li><b>Mission:</b> акцентный текст хранится в meta с ключом <code>accent_text</code>.</li>
            <li><b>CTA:</b> текст кнопки в <code>button_text</code>, ссылка в <code>button_url</code>.</li>
            <li><b>Футер:</b> ссылки в элементах через <code>meta.url</code>.</li>
        </ul>
    </x-filament::section>
</x-filament-panels::page>
