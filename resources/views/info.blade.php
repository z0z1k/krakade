<x-layouts.base title="Інформація">
    <h4>1. Реєстрація</h4>
    <h6>Тут усе просто. Вказуєте своє ім'я, email та телофон для контакту, <b>вибираєте заклад</b>, вигадуєте пароль та реєструєтесь</h6>
    <img src="{{ URL::to('/assets/img/info/registration_place_mini.png') }}">
    
    <h4>2. Додати заклад</h4>
    <h6>Вас автоматично перекидує на сторінку з додаванням закладу. Вказуєте назву, адресу та додаткову інформацію для кур'єрів, якщо потрібно</h6>
    <img src="{{ URL::to('/assets/img/info/add_place_mini.png') }}">

    <h4>3. Можете створювати замовлення</h4>
    <h6>В навбарі у вас з'явиться ваш заклад</h6>
    <img src="{{ URL::to('/assets/img/info/navbar_place.png') }}">
    <h6>Натискаєте на нього та замовляєте</h6>
    <img src="{{ URL::to('assets/img/info/order_create.png') }}">
    <h6>Ви побачите створене замовлення, автоматично вираховану ціну за доставку та його статус, а також зможете змінити час приготування, або скасувати</h6>
    <img src="{{ URL::to('assets/img/info/active_order.png') }}">
    <h6>А наші кур'єри отримають сповіщення про нове замовлення</h6>
    <img src="{{ URL::to('assets/img/info/tg_message.png') }}">
    <h6>Коли знайдеться вільний кур'єр - ви це автоматично побачите на сайті</h6>
    <img src="{{ URL::to('assets/img/info/active_order_with_courier.png') }}">
    <h6>А також буде бачити статус замовлення, коли кур'єр завезе - воно автоматично зникне та опинеться в завершених замовленнях</h6>
</x-layouts.base>