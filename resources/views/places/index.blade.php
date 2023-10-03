<x-layouts.base title="Ваші заклади">

    <table class="table table-bordered">
        <tr>
            <th>Назва</th>
            <th>Адреса</th>
            <th>Телефон</th>
            <th>Email</th>
            <th></th>
            <th></th>
        </tr>

        @foreach($places as $place)
        <tr>
            <td>{{ $place->name }}</td>
            <td>{{ $place->address }}</td>
            <td>{{ $place->phone }}</td>
            <td>{{ $place->email }}</td>
            <td><a href="#">Створити замовлення</a></td>
            <td><a href="#">Редагувати інформацію</a></td>
        </tr>
        @endforeach
    </table>
</x-layouts.base>