<x-layouts.base title="Ваші заклади">

    <table class="table table-bordered">
        <tr>
            <th>Назва</th>
            <th>Адреса</th>
            <th></th>
        </tr>

        @foreach($places as $place)
        <tr>
            <td>{{ $place->name }}</td>
            <td>{{ $place->address }}</td>
            <td><a href="{{ route('orders.create', [ 'place' => $place->id ]) }}">Створити замовлення</a></td>
        </tr>
        @endforeach
    </table>
</x-layouts.base>