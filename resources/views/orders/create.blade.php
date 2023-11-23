<x-layouts.base title="Створити замовлення">
<div id="map"></div>
    <h3>{{$place->name}}</h3>
    <div style="display:none" id="placeLocation">{{ $place->location }}</div>

    <x-form method="post" action="{{ route('orders.store') }}">
        <input type="hidden" name="place_id" value="{{$place->id}}">
        <input type="hidden" name="location" id="location-input">

        <div class="row mb-3">
            <div class="col-12 col-sm-3"><x-form-select id="city" name="city" :options="$cities" label="Населений пункт"/></div>
            <div class="col-12 col-sm-6"><x-form-input name="client_address" id="street" label="Вулиця, будинок" /></div>
            <div class="col-12 col-sm-3"><x-form-input name="client_address_info" label="Квартира..." /></div>
        </div>
        <div class="row">
            <div class="col text-center text-danger">@error('location') {{ $message }} @enderror </div>
        </div>
        <div class="loader"></div>
        <span>Відстань у кілометрах:<span id="distance"></span></span

        <div class="row mb-3">
            <div class="col-8 col-sm-8"><x-form-input name="client_phone" label="Номер телефону:" /></div>
            <div class="col-4 col-sm-4">
                <label for="approximate_ready_at">Готове:</label>
                <input type="time" class="form-control @error('approximate_ready_at') is-invalid @enderror" value="{{old('approximate_ready_at')}}" name="approximate_ready_at"/>
                @error('approximate_ready_at')
                <div class="invalid-feedback">
                {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        
        <div class="mb-3">
            <div class="col-12 col-sm-3 form-check form-check-inline">
                <label for="payment">Кур'єр повинен оплатити</label>
                <input type="checkbox" id="payment-checkbox" name="payment" @if(old('payment') != null) checked @endif>
            </div>
            <div class="form-check form-check-inline">
                <label for="problem">Проблемне замовлення (велике/термінове...):</label>
                <input type="checkbox" id="hard-checkbox" name="problem" @if(old('problem') != null) checked @endif>
            </div>
        </div>
        <div class="row">
            <div id="payment-div" class="col-3" style="display:none @error('payment') display:block @enderror"><x-form-input name="payment" placeholder="Сума оплати"/></div>
            <div id="hard-div" class="col-9" style="display:none"><x-form-input name="problem" placeholder="Опишіть замовлення"/></div>
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