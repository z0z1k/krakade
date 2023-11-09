<x-layouts.base title="Редагувати замовлення">
    @bind($order)
    <x-form method="put" action="{{ route('orders.update', $order->id) }}">
    <div class="mb-3">
            <x-form-input name="client_address" label="Адреса:" />
        </div>

        <div class="mb-3">
                <x-form-input name="client_phone" label="Номер телефону:" />
        </div>

        <div class="cs-form mb-3">
            <label for="be_ready">Буде готове о:</label>
            <input type="time" class="form-control" name="be_ready" :value="17:30" value="{{ $order->be_ready }}"/>
        </div>

        <div class="mb-3">
            <x-form-input name="payment_type" label="Кур'єр повинен оплатити:"/>
        </div>        

        <div class="mb-3">
            <x-form-textarea name="comment" label="Коментар:"></x-form-textarea>
        </div>

        <div class="mb-3">
                <button class="btn btn-primary">Редагувати</button>
        </div>
        
        <a href="#" class="btn btn-outline-danger">Скасувати замовлення</a>
    </x-form>
    @endbind
</x-layouts.base>