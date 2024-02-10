<x-layouts.base title="Користувачі">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>Ім'я</th>
                <th>Email</th>
                <th>Телефон</th>
                <th>Замовлень за місяць</th>
                <th></th>
            </tr>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <th>{{ $user->phone }}</td>
                <td>{{ $user->orders }}</td>
                <td>
                    <a href="{{ route('users.roles', [ $user->id]) }}">Змінити ролі</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-layouts.base>