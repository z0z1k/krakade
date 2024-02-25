<x-layouts.base title="{{ $title }}">
<div class="row">
        <table class="table">
            @foreach($orders as $order)
                <tr>
                    <th>{{ $order->date }}</th>
                    <th>{{ $order->place->name }}</th>
                    <th>{{ $order->address }}</th>
                    <th>{{ $order->client_phone }}</th>
                    <th>{{ $order->payment }}</th>
                    <th>{{ $order->comment }}</th>
                    <th><a class="link-dark" href="{{ route('orders.show', $order->id) }}">Повна інформація</a></th>
                </tr>
            @endforeach
        </table>
@vite(['resources/js/websocket.js'])
</x-layouts.base>
