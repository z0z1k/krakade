<?php
    
    if (isset($user)) {
        $pageTitle = 'Створити замовлення';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $params = extractFields($_POST, ['address', 'phone', 'beReady', 'paymentType' , 'orderComent']);
            $params['place'] = $userName;

            $errors = validateErrors($params);
            $tgMessage = $params['place'] . " потрібен кур'єр. Замовлення буде готове о " . $params['beReady'] . ". Адреса: " . $params['address'] . ", номер телефону: " . $params['phone'] . "\n" . $params['paymentType'] . "\n" . $params['orderComent'];
            
            
            if (empty($errors)) {
                $params['m_id'] = message_to_telegram($tgMessage)['result']['message_id'];
                createOrder($params);
                header('Location: ' . BASE_URL);
                exit();
            }
        }

        if ($url != 'complete') {
            $activeOrders = getActiveOrders($userName);
            $orderTypes = 'complete';
            $orderTypesText = 'Виконані замовлення';
            $listOrders = template('orders/v_active', ['orders' => $activeOrders]);
        } else {
            $orderTypes = '';
            $orderTypesText = 'Активні замовлення';
            $pageTitle = 'Виконані замовлення';
            $completeOrders = getCompleteOrders($userName);
            $listOrders = template('orders/v_ready', ['orders' => $completeOrders]);
        }

        $newOrder = template('orders/v_create', ['orderTypes' => $orderTypes, 'orderTypesText' => $orderTypesText]);        
        $pageContent = template('base/v_2col', ['newOrder' => $newOrder, 'listOrders' => $listOrders]);

    } else if (isset($user) && $user['status'] == 2) {
        header('Location: ' . BASE_URL . 'allactive');
        exit();
    } else{
        header('Location: ' . BASE_URL . 'auth');
        exit;
    }