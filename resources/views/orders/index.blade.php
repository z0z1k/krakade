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
                    @if(!$order->ready)                    
                    @if($place)<a href="{{ route('orders.minusTime', $order->id) }}" class="btn btn-outline-success btn-sm">-5хв</a>@endif
                    Буде готове {{ $order->ready_at }}
                    @if($place)<a href="{{ route('orders.plusTime', $order->id) }}" class="btn btn-outline-success btn-sm">+5хв</a>@endif
                    @else                    
                    <span class="badge text-bg-success">Замовлення готове {{ $order->ready_at }}</span>
                    @endif
                    @if($order->courier_arriving_time != null)
                    <br><span class="badge text-bg-warning">Кур'єр буде о: {{ $order->courier_arriving_time }}</span>
                    @if($courier)
                    <a href="{{ route('orders.courierMinusTime', $order->id) }}" class="btn btn-outline-success btn-sm">-5хв</a>
                    <a href="{{ route('orders.courierPlusTime', $order->id) }}" class="btn btn-outline-success btn-sm">+5хв</a>
                    @endif
                    @endif

    
                    <br>
                    {{ $order->comment }}<br>
                    {{ $order->payment_type }}<br>
                    <span class="badge text-bg-info">
                    {{ $order->status->text() }}<br>
                    {{ $order->courier->name ?? '' }}
                    {{ $order->courier->phone ?? ''}}
                    </span>
                    @if(!$order->ready)
                    @if($place)
                    <a href="{{ route('orders.ready', $order->id)}}"><span class="badge text-bg-success">Позначити готовим</span></a>
                    @endif
                    @endif
                </p>
                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-dark">Повна інформація</a>
                
                @if($place)
                    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-outline-dark">Редагувати</a>
                @endif
                @if($courier)

                @endif

                <br>Заявлений час приготування: {{ $order->be_ready }}
          </div>
        </div>
    </div>
    @endforeach
</div>
@vite(['resources/js/websocket.js'])
</x-layouts.base>