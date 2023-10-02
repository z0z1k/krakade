<x-layouts.base title="Користувачі">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>Id</th>
                <th>Email</th>
                <th></th>
                <th></th>
            </tr>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <a href="{{ route('users.roles', [ $user->id]) }}">Додаткова інформація</a>
                </td>
                <td>
                    <a href="{{ route('users.roles', [ $user->id]) }}">Змінити ролі</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-layouts.base>