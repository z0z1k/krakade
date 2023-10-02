<x-layouts.base title="Створити замовлення">
    <x-form method="post" action="{{ route('orders.store') }}">
        <x-form-input name="client_address" placeholder="Адреса" />
        <x-form-input name="client_phone" placeholder="Номер телефону" />
        <x-form-input name="be_ready" placeholder="Буде готове о" />
        <x-form-input name="payment_type" placeholder="Кур'єр повинен оплатити:" />
        <x-form-textarea name="comment" placeholder="Коментар"></x-form-textarea>
        <button class="btn btn-primary">Створити замовлення</button>
    </x-form>
</x-layouts.base>