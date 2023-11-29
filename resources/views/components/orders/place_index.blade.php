@foreach($orders as $order)
<div class="col-6 col-md-4">
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
                        <img src="{{ URL::to('/assets/img/icons/time.png') }}">
                        Буде готове о 
                        <a href="{{ route('orders.minusTime', $order->id) }}" class="btn btn-outline-success btn-sm">&#8656;</a>
                        {{ $order->prepared_at }}
                        <a href="{{ route('orders.plusTime', $order->id) }}" class="btn btn-outline-success btn-sm">&#8658;</a>
                    </li>
                    @if($order->approximate_courier_arrived_at)
                    <li class="list-group-item">
                        <span class="badge text-bg-warning">Кур'єр буде о: {{ $order->approximate_courier_arrived_at }}</span>
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
                <a href="{{ route('orders.cancel', $order->id) }}" class="btn btn-outline-danger">Скасувати</a>
                
                <p class="card-text">
                    <span class="badge text-bg-info">Створено: {{ $order->created_at->format('H:i') }}</span>
                    <span class="badge text-bg-info">Заявлений час приготування: {{ $order->approximate_ready_at }}</span>
                </p>
          </div>
        </div>
    </div>
@endforeach