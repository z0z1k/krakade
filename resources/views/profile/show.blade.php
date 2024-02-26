<x-layouts.base title="Редагувати профіль">
    <table class="table">
        <tr>
            <th>Ваші ролі:</th>
            @foreach($user->roles as $role)
                <td>{{$role->name}}</td>
            @endforeach
        </tr>
    </table>
    <a href="{{ route('profile.password.edit') }}" class="btn btn-success">Змінити пароль</a>

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


    <a href="{{ route('login.exit') }}" class="btn btn-danger mt-3">Вийти</a>

</x-layouts.base>
