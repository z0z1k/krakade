<x-layouts.base title="Виконані замовлення">
<div class="row">
    @foreach($orders as $order)
    
    <div class="col-sm-4">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $order->place->name }}</h5>
                <p class="card-text">
                    {{ $order->client_address }}<br>
                    {{ $order->client_phone }}<br>
                    {{ $order->comment }}<br>
                    {{ $order->payment_type }}<br>
                    <span class="badge text-bg-info text-left">
                    {{ $order->courier->name }}<br>
                    {{ $order->courier->phone}}<br>
                    Отримано {{ $order->get_at }}<br>
                    Доставлено {{ $order->delivered_at }}
                    </span>
                </p>
                </div>
        </div>
    </div>
    @endforeach
</div>
@vite(['resources/js/websocket.js'])
</x-layouts.base>