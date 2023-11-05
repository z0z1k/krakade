<x-layouts.base title="Замовлення">
{{$order}}

<table class="table table-bordered">
    <tr>
        <td>Статус</td>
        <td>{{ $order->status->text() }}</td>
    </tr>
    <tr>
        <td>Кур'єр</td>
        <td>{{ $order->courier_id }}</td>
    </tr>
</table>
</x-layouts.base>