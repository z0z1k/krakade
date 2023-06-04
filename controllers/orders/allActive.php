<?php
    if (isset($user) && $user['status'] == 2) {
        $pageTitle = 'Активні замовлення';

        $orders = getAllActiveOrders();
        
        $pageContent = template('orders/v_all', ['orders' => $orders, 'userID' => $user['id_user']]);
    } else if (isset($user) && $user['status'] == 1) {
        header('Location: ' . BASE_URL);
        exit();
    } else{
        header('Location: ' . BASE_URL . 'auth');
        exit;
    }