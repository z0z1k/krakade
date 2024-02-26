<x-layouts.base title="{{ $place->name }}">
    <dl class="row">
        <dt class="col-sm-2">Адреса</dt>
        <dd class="col-sm-10">{{ $place->address }}</dd>

        <dt class="col-sm-2">Телефон</dt>
        <dd class="col-sm-10">{{ $place->user->phone }}</dd>

        <dt class="col-sm-2">Кількість замовлень</dt>
        <dd class="col-sm-10">{{ $orders->count() }}</dd>
    </dl>
</x-layouts.base>
