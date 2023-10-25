<x-layouts.base title="Усі замовлення">
    <table class="table">
        <tr>
            <th>Заклад</th>
            <th>Буде готове</th>
            <th>Адреса клієнта</th>
            <th>Телефон клієнта</th>
            <th>Коментар</th>
            <th>Оплата</th>
            <th>Кур'єр</th>
            <th>Статус</th>
        </tr>

        @foreach($orders as $order)
        <tr>
            <td>{{ $order->place->name }}</td>
            <td>{{ $order->be_ready }}</td>
            <td>{{ $order->client_address }}</td>
            <td>{{ $order->client_phone }}</td>
            <td>{{ $order->payment_type }}</td>
            <td>Courier must be here</td>
            <td>{{ $order->status }}</td>
        </tr>
        @endforeach
    </table>
</x-layouts.base>