<x-layouts.base title="Ваші заклади">

    <table class="table table-bordered">
        <tr>
            <th>Назва</th>
            <th>Адреса</th>
            <th></th>
        </tr>

        @foreach($places as $place)
        <tr>
            <td>
                <a href="{{ route('places.show', $place->id) }}">
                    {{ $place->name }}
                </a>
            </td>
            <td>{{ $place->address }}</td>
            <td><a href="{{ route('orders.create', [ 'place' => $place->id ]) }}">Створити замовлення</a></td>
        </tr>
        @endforeach
    </table>

    <a href="{{ route('places.create') }}" class="btn btn-primary">Додати заклад</a>
</x-layouts.base>
