<x-layouts.base title="{{ $title }}">
<div class="row">
    @foreach($orders as $order)
    
    <div class="col-sm-6">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $order->place->name }}</h5>
                <p class="card-text">
                    {{ $order->client_address }}<br>
                    {{ $order->client_phone }}<br>
                    @if($place)<a href="{{ route('orders.minusTime', $order->id) }}" class="btn btn-outline-success btn-sm">-5хв</a>@endif
                    {{ $order->be_ready }}
                    @if($place)<a href="{{ route('orders.plusTime', $order->id) }}" class="btn btn-outline-success btn-sm">+5хв</a>@endif
                    <br>
                    {{ $order->comment }}<br>
                    {{ $order->payment_type }}<br>
                    <span class="badge text-bg-info">
                    {{ $order->status->text() }}<br>
                    {{ $order->courier->name ?? '' }}
                    {{ $order->courier->phone ?? ''}}
                    </span>
                </p>
                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-dark">Повна інформація</a>
                
                @if($place)
                    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-outline-dark">Редагувати</a>
                @endif
                @if($courier)

                @endif
                </div>
        </div>
    </div>
    @endforeach
</div>
@vite(['resources/js/websocket.js'])
</x-layouts.base>