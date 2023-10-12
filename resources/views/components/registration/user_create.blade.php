@props([
    'type',
    'action'
]);

<x-layouts.base title="Реєстрація {{ $type }}">
    <x-form method="post" action="{{ $action }}">
        <div class="mb-3">
            <x-form-input name="name" label="Ім'я" />
        </div>
        <div class="mb-3">
            <x-form-input name="email" label="Email" />
        </div>
        <div class="mb-3">
            <x-form-input name="phone" label="Номер телефону" />
        </div>
        <div class="mb-3">
            <x-form-input type="password" name="password" label="Пароль" />
        </div>

        {{ $slot }}
        <button class="btn btn-success">Зареєструватися</button>
    </x-form>
</x-layouts.base>