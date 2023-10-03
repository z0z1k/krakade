<x-layouts.base title="Change password">
    <x-form action="{{ route('profile.password.update') }}" method="put">
        <div class="mt-3">
            <x-form-input type="password" name="current" label="Current password" />
        </div>
        <div class="mt-3">
            <x-form-input type="password" name="password" label="New password" />
        </div>
        <div class="mt-3">
            <x-form-input type="password" name="password_confirmation" label="Repeat new password" />
        </div>
        <button class="btn btn-success">Change password</button>
    </x-form>
</x-layouts.base>