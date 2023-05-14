<?php
    if (isset($user)) {
        $pageTitle = 'Активні замовлення';

        $orders = getAllActiveOrders();
        
        $pageContent = template('orders/v_all', ['orders' => $orders]);
    } else {
        header('Location: ' . BASE_URL . 'auth');
        exit;
    }