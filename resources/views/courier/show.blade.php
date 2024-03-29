<x-layouts.base title="Статистика">
    <table class="table">
        <tr>
            <th><span class="badge text-bg-info">@if($isCourier)Кур'єр@elseНемає статусу кур'єра@endif</span></th>
        </tr>
        <tr><th>{{ $user->name }}</th></tr>
        <tr><th>Доставок: {{ $orders->count() }}</th></tr>
        <tr><th>Середній час доставки: {{ $orders->averageDeliveryTime }} хв</th></tr>
    </table>
    <table class="table table-light">
        <tr>
            <th>Заклад</th>
            <th>Адреса доставки</th>
            <th>Дата</th>
            <th>Заявлений час приготування</th>
            <th>Отримав</th>
            <th>Доставив</th>
            <th>Час доставки</th>
            <th>~</th>
        </tr>
        @foreach($orders as $order)
        <tr>
            <th>{{ $order->place->name }}</th>
            <th>{{ $order->address }}</th>
            <td>{{ $order->date }}</td>
            <td>{{ $order->approximate_ready_at }}</td>
            <td>{{ $order->taken_at }}</td>
            <td>{{ $order->delivered_at }}</td>
            <td>{{ $order->deliveryTime }}хв</td>
            <td><a href="{{ route('orders.show', $order->id) }}">+</a></td>
        </tr>
        @endforeach

    </table>
</x-layouts.base>
