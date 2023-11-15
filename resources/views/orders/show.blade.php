<x-layouts.base title="Замовлення">
{{ $order->date }}

<table class="table table-bordered">
    <tr>
        <td>Статус</td>
        <td>{{ $order->status->text() }}</td>
    </tr>
    <tr>
        <td>Заклад</td>
        <td>{{ $order->place->name }}</td>
    </tr>
    <tr>
        <td>Кур'єр</td>
        <td>{{ $order->courier->name ?? '' }}</td>
    </tr>
    <tr>
        <td>Адреса</td>
        <td>{{ $order->client_address }}</td>
    </tr>
    <tr>
        <td>Заявлений час приготування</td>
        <td>{{ $order->be_ready }}</td>
    </tr>
    <tr>
        <td>Фактичний час приготування</td>
        <td>{{ $order->ready_at }}</td>
    </tr>
    <tr>
        <td>Номер клієнта</td>
        <td>{{ $order->client_phone }}</td>
    </tr>
    <tr>
        <td>Оплата</td>
        <td>{{ $order->payment_type }}</td>
    </tr>
    <tr>
        <td>Коментар</td>
        <td>{{ $order->comment }}</td>
    </tr>
    <tr>
        <td>Замовлення створено</td>
        <td>{{ $order->created_at->format('H:i') }}</td>
    </tr>
    <tr>
        <td>Отримано</td>
        <td>{{ $order->get_at }}</td>
    </tr>
    <tr>
        <td>Доставлено</td>
        <td>{{ $order->delivered_at }}</td>
    </tr>    
</table>


<x-form method="{{ $method }}" action="{{ route($link, $order->id) }}">
    <button class="btn btn-primary">{{ $text }}</button>
</x-form>

</x-layouts.base>