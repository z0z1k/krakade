<?php
    if ($user['status'] == 2) {
        setCourier($routerRes['params']['order'], $routerRes['params']['courier']);
        header('Location: ' . BASE_URL . 'allactive');
        exit();
    } elseif ($user['status'] == 1) {
        header('Location: ' . BASE_URL);
        exit();
    } else {
        header('Location: ' . BASE_URL . 'auth');
        exit();
    }