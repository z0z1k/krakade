<x-layouts.base title="Усі замовлення">
<div class="row">
    @foreach($orders as $order)
    
    <div class="col-sm-6">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $order->place->name }}</h5>
                <p class="card-text">
                    {{ $order->client_address }}<br>
                    {{ $order->client_phone }}<br>
                    @can('place')<a href="{{ route('orders.plusTime', $order->id) }}" class="btn btn-outline-success btn-sm">-5хв</a>@endif
                    {{ $order->be_ready }}
                    @can('place')<a href="{{ route('orders.minusTime', $order->id) }}" class="btn btn-outline-success btn-sm">+5хв</a>@endif
                    <br>
                    {{ $order->comment }}<br>
                    {{ $order->payment_type }}<br>
                    {{ $order->status->text() }}<br>
                    {{ $order->courier->name ?? '' }}
                </p>
                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-dark">Повна інформація</a>
                
                <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-outline-dark">Редагувати</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
</x-layouts.base>