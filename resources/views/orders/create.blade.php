<x-layouts.base title="Створити замовлення">
    <h3>{{$place->name}}</h3>
    <x-form method="post" action="{{ route('orders.store') }}">
        <input type="hidden" name="place_id" value="{{$place->id}}">

        <div class="mb-3">
            <x-form-input name="client_address" label="Адреса:" />
        </div>

        <div class="mb-3">
                <x-form-input name="client_phone" label="Номер телефону:" />
        </div>

        <div class="cs-form mb-3">
            <label for="be_ready">Буде готове о:</label>
            <input type="time" class="form-control" name="be_ready"/>
        </div>

        <div class="mb-3">
            <x-form-input name="payment_type" label="Кур'єр повинен оплатити:" />
        </div>

        <div class="mb-3">
            <x-form-textarea name="comment" label="Коментар:"></x-form-textarea>
        </div>

        <div class="mb-3">
                <button class="btn btn-primary">Створити замовлення</button>
        </div>
    </x-form>
</x-layouts.base>