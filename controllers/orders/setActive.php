<?php

    setActive($routerRes['params']['id']);

    var_dump($user['status']);

    if ($user['status'] == 1) {
        header('Location: ' . BASE_URL);
        exit();
    } elseif ($user['status'] == 2) {
        header('Location: ' . BASE_URL . 'allactive');
        exit();
    }
    