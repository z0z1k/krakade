<x-layouts.base title="User roles">
    @bind($user)
        <x-form method="put" action="{{ route('users.roles', [ $user->id ]) }}">
            <div class="mb-3">
                <x-form-select name="roles[]" label="Roles" :options="$roles->pluck('name', 'id')" multiple many-relation />
            </div>
        <button class="btn btn-success">Change role</button>
        </x-from>
    @endbind
</x-layouts.base>