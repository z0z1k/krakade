<x-layouts.base title="Виконані замовлення">
<div class="row">
    @foreach($orders as $order)
    
    <div class="col-sm-4">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $order->place->name }}</h5>
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
                    <li class="list-group-item">
                        <span class="badge text-bg-warning">Кур'єр отрмав: {{ $order->taken_at }}</span>
                    </li>
                    <li class="list-group-item">
                        <span class="badge text-bg-warning">Доставлено: {{ $order->taken_at }}</span>
                    </li>
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
                </div>
        </div>
    </div>
    @endforeach
</div>
@vite(['resources/js/websocket.js'])
</x-layouts.base>