
    Виконані замовлення:
    <? foreach ($orders as $order): ?>
        <div>
            Адреса: <?=$order['client_address']?> <br>
            Номер клієнта: <?=$order['client_phone']?> <br>
            Замовлення створено о <?=$order['dt_add']?> <br>
            Кур'єр отрмав: <?=$order['dt_get']?> <br>
            Доставлено: <?=$order['dt_delivered']?> <br>
            <hr>
        </div>
    <? endforeach; ?>

