@foreach($orders as $order)
<div class="col-6 col-md-4">
        <div class="card mb-3">
            <div class="card-body">

            <div class="row">
                <div class="col">
                    <a href="{{ route('places.show', $order->place->id) }}" class="link link-dark">
                        <h5 class="card-title">{{ $order->place->name }}</h5>
                    </a>
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
                        <img src="{{ URL::to('/assets/img/icons/time.png') }}">Готове о {{ $order->prepared_at }}
                    </li>
                    @if($order->approximate_courier_arrived_at && !$order->taken_at)
                    <li class="list-group-item">
                        <span class="badge text-bg-warning">Кур'єр буде о: {{ $order->approximate_courier_arrived_at }}</span>
                        @if($order->can_edit)
                        <br>
                        <a href="{{ route('orders.courierMinusTime', $order->id) }}" class="btn btn-outline-success btn-sm">-5хв</a>
                        <a href="{{ route('orders.courierPlusTime', $order->id) }}" class="btn btn-outline-success btn-sm">+5хв</a>
                        @endif
                    </li>
                    @endif
                    @if($order->taken_at)
                    <li class="list-group-item">
                        <span class="badge text-bg-warning">Кур'єр отрмав: {{ $order->taken_at }}</span>
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
                    <li class="list-group-item">
                        Ціна: {{ $order->price }}
                    </li>
                </ul>

                @if(!$order->courier)
                    <a href="{{ route('orders.take', $order->id) }}" class="btn btn-outline-dark">Взяти замовлення</a>
                @elseif($order->can_edit)
                @if($order->taken_at == null)
                    <a href="{{ route('orders.changeCourier', $order->id) }}" class="btn btn-outline-dark">Перепризначити</a>
                @endif
                    <x-form method="{{ $order->status->routeMethod() }}" action="{{ route($order->status->routeLink(), $order->id) }}">
                        <button class="btn btn-outline-dark">Змінити статус: {{ $order->status->textForCourier() }}</button>
                    </x-form>
                @endif

                <p class="card-text">
                    <span class="badge text-bg-info">Створено: {{ $order->created_at->format('H:i') }}</span>
                    <span class="badge text-bg-info">Заявлений час приготування: {{ $order->approximate_ready_at }}</span>
                </p>
          </div>
        </div>
    </div>
@endforeach
