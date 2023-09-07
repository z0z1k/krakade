<?php

$pageTitle = 'Редагувати замовлення';

$idOrd = $routerRes['params']['id'];
$order = getOrder($idOrd);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $params = extractFields($_POST, ['address', 'phone', 'beReady', 'paymentType' , 'orderComent']);

    $errors = validateErrors($params);
    deleteMessage(getTgIdByOrId($idOrd));
    $tgMessage = "!Оновлення! " . $userName . " потрібен кур'єр. Замовлення буде готове о " . $params['beReady'] . ". Адреса: " . $params['address'] . ", номер телефону: " . $params['phone'] . "\n" . $params['paymentType'] . "\n" . $params['orderComent'];
    
    
    if (empty($errors)) {
        $params['m_id'] = message_to_telegram($tgMessage)['result']['message_id'];
        $params['order_id'] = $idOrd;

        updateOrder($params);
        header('Location: ' . BASE_URL);
        exit();
    }
}

$newOrder = template('orders/v_edit', ['order' => $order]);
$pageContent = template('base/v_2col', ['newOrder' => $newOrder, 'listOrders' => '/']);