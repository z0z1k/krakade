<x-layouts.base title="Редагувати профіль">
    <table class="table">
        <tr>
            <th>Ваші ролі:</th>
            @foreach($user->roles as $role)        
                <td>{{$role->name}}</td>
            @endforeach
        </tr>
    </table>

    <x-form method="put" action="{{ route('profile.update') }}">
        @bind($user)
        <div class="mb-3">
            <x-form-input name="email" label="Email"/>
        </div>
        <div class="mb-3">
            <x-form-input name="name" label="Ім'я"/>
        </div>

        <button class="btn btn-primary">Редагувати</button>
        @endbind
    </x-form>

    <x-form method="put" action="{{ route('generatetoken') }}">
    <button>generate</button>
    </x-from>
    
    <a href="{{ route('profile.password.edit') }}">Змінити пароль</a>
    
</x-layouts.base>