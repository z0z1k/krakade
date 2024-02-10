<x-layouts.base title="Користувачі">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>Id</th>
                <th>Email</th>
                <th>Ім'я</th>
                <th></th>
                <th>Замовлень за місяць</th>
            </tr>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->name }}</td>
                <td>
                    <a href="{{ route('users.roles', [ $user->id]) }}">Змінити ролі</a>
                </td>
                <td>{{ $user->orders }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-layouts.base>