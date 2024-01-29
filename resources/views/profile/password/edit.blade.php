<x-layouts.base title="Change password">
    <x-form action="{{ route('profile.password.update') }}" method="put">
        <div class="mb-3">
            <x-form-input type="password" name="current" label="Старий пароль" />
        </div>
        <div class="mb-3">
            <x-form-input type="password" name="password" label="Новий пароль" />
        </div>
        <div class="mb-3">
            <x-form-input type="password" name="password_confirmation" label="Повторіть новий пароль" />
        </div>
        <div class="mb-3">
            <button class="btn btn-success">Change password</button>
        </div>
    </x-form>
</x-layouts.base>