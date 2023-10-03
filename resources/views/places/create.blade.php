<x-layouts.base title="Додати заклад">
    <x-form method="post" action="{{ route('places.store') }}">
        <div class="mb-3">
            <x-form-input name="name" label="Назва" />
        </div>
        <div class="mb-3">
            <x-form-input name="address" label="Адреса" />
        </div>
        <div class="mb-3">
            <x-form-input name="phone" label="Телефон" />
        </div>
        <div class="mb-3">
            <x-form-input name="email" label="Email" />
        </div>
        <button class="btn btn-success">Додати</button>
    </x-from>
</x-layouts.base>