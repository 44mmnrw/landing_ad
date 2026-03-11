@php
    /** @var \Illuminate\Support\ViewErrorBag $viewErrors */
    $viewErrors = $errors ?? new \Illuminate\Support\ViewErrorBag();
@endphp

<div class="calc-modal" id="calcModal" aria-hidden="true" data-auto-open="{{ $viewErrors->any() ? '1' : '0' }}">
    <div class="calc-modal__overlay" data-calc-modal-close></div>
    <div class="calc-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="calcModalTitle">
        <div class="calc-modal__head">
            <h3 id="calcModalTitle">Заявка на расчет</h3>
            <button type="button" class="calc-modal__close" data-calc-modal-close aria-label="Закрыть">×</button>
        </div>

        <form class="calc-modal__form" id="calcModalForm" method="post" action="{{ route('quote-requests.store') }}">
            @csrf
            <input type="hidden" name="source_page" value="{{ url()->current() }}">

            @if(session('quote_success'))
                <div class="form-alert form-alert--success">{{ session('quote_success') }}</div>
            @endif

            @if($viewErrors->any())
                <div class="form-alert form-alert--error">Проверьте корректность заполнения полей и попробуйте снова.</div>
            @endif

            <label class="calc-field">
                <span>Имя <b>*</b></span>
                <input type="text" name="name" placeholder="Ваше имя" value="{{ old('name') }}" required>
            </label>

            <label class="calc-field">
                <span>Телефон <b>*</b></span>
                <input type="tel" name="phone" placeholder="+7 (___) ___-__-__" inputmode="tel" autocomplete="tel" maxlength="18" value="{{ old('phone') }}" required>
            </label>

            <label class="calc-field">
                <span>Маршрут <b>*</b></span>
                <input type="text" name="route" placeholder="Откуда → Куда" value="{{ old('route') }}" required>
            </label>

            <label class="calc-field">
                <span>Тип груза <b>*</b></span>
                <select name="cargo_type" required>
                    <option value="" @selected(!old('cargo_type')) disabled>Выберите тип груза</option>
                    <option value="Сборный груз" @selected(old('cargo_type') === 'Сборный груз')>Сборный груз</option>
                    <option value="Опасный груз" @selected(old('cargo_type') === 'Опасный груз')>Опасный груз</option>
                    <option value="Негабаритный груз" @selected(old('cargo_type') === 'Негабаритный груз')>Негабаритный груз</option>
                    <option value="Промышленное оборудование" @selected(old('cargo_type') === 'Промышленное оборудование')>Промышленное оборудование</option>
                    <option value="Таможенное оформление" @selected(old('cargo_type') === 'Таможенное оформление')>Таможенное оформление</option>
                </select>
            </label>

            <label class="calc-field calc-field--textarea">
                <span>Комментарий</span>
                <textarea name="comment" placeholder="Дополнительная информация о грузе">{{ old('comment') }}</textarea>
            </label>

            <label class="calc-consent">
                <input type="checkbox" name="consent" @checked(old('consent')) required>
                <span>
                    Я согласен на
                    <a href="{{ route('custom-pages.show', ['slug' => 'privacy']) }}" target="_blank" rel="noopener noreferrer">
                        обработку персональных данных
                    </a>
                </span>
            </label>

            <button type="submit" class="calc-submit">Отправить заявку</button>
        </form>
    </div>
</div>
