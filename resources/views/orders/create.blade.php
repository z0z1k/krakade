<x-layouts.base title="Створити замовлення">
    <h3>{{$place->name}}</h3>
    <div style="display:none" id="placeLocation">{{ $place->location }}</div>

    <x-form method="post" action="{{ route('orders.store') }}">
        <input type="hidden" name="place_id" value="{{$place->id}}">

        <div class="row mb-3">
            <div class="col-12 col-sm-3"><x-form-input name="client_city" id="city" label="Місто" /></div>
            <div class="col-12 col-sm-6"><x-form-input name="client_address" id="street" label="Вулиця, будинок" /></div>
            <div class="col-12 col-sm-3"><x-form-input name="client_address_info" label="Квартира..." /></div>
        </div>
        <span id="distance"></div>

        <div class="row mb-3">
            <div class="col-8 col-sm-8"><x-form-input name="client_phone" label="Номер телефону:" /></div>
            <div class="col-4 col-sm-4">
                <label for="be_ready">Готове:</label>
                <input type="time" class="form-control" name="be_ready"/>
            </div>
        </div>
        
        <div class="mb-3">
            <div class="col-12 col-sm-3 form-check form-check-inline">
                <x-form-checkbox id="payment-checkbox" name="payment" label="Кур'єр повинен оплатити:" />
            </div>
            <div class="form-check form-check-inline">
                <x-form-checkbox id="hard-checkbox" name="hard" label="Проблемне замовлення (велике/термінове...):" />
            </div>
        </div>
        <div class="row">
            <div id="payment-div" class="col-3" style="display:none"><x-form-input name="payment_type" /></div>
            <div id="hard-div" class="col-9" style="display:none"><x-form-input name="hard_order" /></div>
        </div>
        <div class="mb-3">
            <x-form-textarea name="comment" label="Коментар:"></x-form-textarea>
        </div>

        <div class="mb-3">
                <button class="btn btn-primary">Створити замовлення</button>
        </div>
    </x-form>
@vite(['resources/js/orders_create.js'])
</x-layouts.base>