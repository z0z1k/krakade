<x-layouts.base title="{{ $title }}">
<div class="row">
    @foreach($orders as $order)

    <div class="col-sm-4">
        <div class="card mb-3">
            <div class="card-body">
                
            <div class="row">
                <div class="col">
                    <h5 class="card-title">{{ $order->place->name }}</h5>
                </div>
                <div class="col">
                    <span class="badge text-bg-info">
                    {{ $order->status->text() }}<br>
                    {{ $order->courier->name ?? '' }}
                    {{ $order->courier->phone ?? '' }}
                    </span>
                </div>
            </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <img src="{{ URL::to('/assets/img/icons/map.png') }}">{{ $order->address }}
                    </li>
                    <li class="list-group-item">
                        <img src="{{ URL::to('/assets/img/icons/phone.png') }}">{{ $order->client_phone }}
                    </li>
                    <li class="list-group-item">
                        <img src="{{ URL::to('/assets/img/icons/time.png') }}">Буде готове о {{ $order->prepared_at }}
                    </li>
                    @if($order->approximate_courier_arrived_at)
                    <li class="list-group-item">     
                        <span class="badge text-bg-warning">Кур'єр буде о: {{ $order->approximate_courier_arrived_at }}</span>
                        @if($order->can_edit)
                        <a href="{{ route('orders.courierMinusTime', $order->id) }}" class="btn btn-outline-success btn-sm">-5хв</a>
                        <a href="{{ route('orders.courierPlusTime', $order->id) }}" class="btn btn-outline-success btn-sm">+5хв</a>
                        @endif
                    </li>
                    @endif
                    @if($order->comment)
                    <li class="list-group-item">
                        <img src="{{ URL::to('/assets/img/icons/comment.png') }}">{{ $order->comment }}
                    </li>
                    @endif                    
                    <li class="list-group-item">
                        <img src="{{ URL::to('/assets/img/icons/payment.png') }}">{{ $order->payment }}
                    </li>
                </ul>

                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-dark">Повна інформація</a>
                @if(!$order->courier)
                    <a href="{{ route('orders.take', $order->id) }}" class="btn btn-outline-dark">Взяти замовлення</a>         
                @elseif($order->can_edit)
                    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-outline-dark">Перепризначити</a>
                @endif
                
                <p class="card-text">
                    <span class="badge text-bg-info">Створено: {{ $order->created_at->format('H:i') }}</span>
                    <span class="badge text-bg-info">Заявлений час приготування: {{ $order->approximate_ready_at }}</span>
                </p>
          </div>
        </div>
    </div>

    @endforeach

    <div class="col-sm-6">
        для закладу:
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Назва закладу</h5>
                <p class="card-text">
                    Адреса клієнту<br>
                    Номер клієнту<br>
                    @if(!$order->is_ready)                    
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

</div>
@vite(['resources/js/websocket.js'])
</x-layouts.base>