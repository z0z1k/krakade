<x-layouts.base title="Замовлення # {{ $order->id }} {{ $order->date }}">

    <dl class="row">
        <dt class="col-sm-3">Статус</dt>
        <dd class="col-sm-9">{{ $order->status->text() }}</dd>

        <dt class="col-sm-3">Заклад</dt>
        <dd class="col-sm-9">{{ $order->place->name }}</dd>

        <dt class="col-sm-3">Кур'єр</dt>
        <dd class="col-sm-9">{{ $order->courier?->name}}</dd>

        <dt class="col-sm-3">Адреса</dt>
        <dd class="col-sm-9">{{ $order->client_address }}</dd>

        <dt class="col-sm-3">Коментар</dt>
        <dd class="col-sm-9">{{ $order->comment }}</dd>

        <dt class="col-sm-3">Заявлений час приготування</dt>
        <dd class="col-sm-9">{{ $order->approximate_ready_at }}</dd>

        <dt class="col-sm-3">Номер клієнта</dt>
        <dd class="col-sm-9">{{ $order->client_phone }}</dd>

        <dt class="col-sm-3">Оплата</dt>
        <dd class="col-sm-9">{{ $order->payment ?? 'Без оплати' }}</dd>

        <dt class="col-sm-3">Замовлення створено</dt>
        <dd class="col-sm-9">{{ $order->created_at->format('H:i') }}</dd>

        <dt class="col-sm-3">Отримано</dt>
        <dd class="col-sm-9">{{ $order->taken_at }}</dd>

        <dt class="col-sm-3">Доставлено</dt>
        <dd class="col-sm-9">{{ $order->delivered_at }}</dd>

        <dt class="col-sm-3">Ціна доставки</dt>
        <dd class="col-sm-9">{{ $order->price }}</dd>
    </dl>

</x-layouts.base>
