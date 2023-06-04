<?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include "../init.php";

        $activeOrders = getActiveOrders($userName);

        foreach ($activeOrders as &$order) {
            $order['client_address'] = "Адреса: {$order['client_address']}";
            $order['client_phone'] = "Номер клієнта: {$order['client_phone']}";
            $order['beReady'] = "Буде готове о {$order['beReady']}";

            if ($order['paymentType'] == 'Оплата не потрібна') {
                $order['paymentType'] = "Кур'єр не оплачує";
            } else {
                $order['paymentType'] = "Кур'єр оплачує " . mb_substr($order['paymentType'], 18);
            }

            if ($order['orderComent'] != '') {
                $order['orderComent'] = "Коментар: {$order['orderComent']}";
            }

            if ($order['dt_get'] != NULL){
                $dt = substr($order['dt_get'], 10);
                $order['dt_get'] = "Кур'єр отримав о {$dt}";
            } else {
                $order['dt_get'] = '';
            }

            if ($order['courier_id'] === NULL) {
                $order['courier'] = "Кур'єри вже б'ються за це замовлення";
            } else {
                $order['courier'] = "Кур'єр: " . $order['name'] . ", номер телефону " . $order['number'];
            }

        }
        
        echo json_encode($activeOrders);
    } else {
        echo 'Not authorized';
    }
