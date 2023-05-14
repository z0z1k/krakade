<?php

    setReady($routerRes['params']['id']);
    deleteMessage(getTgIdByOrId($routerRes['params']['id']));

    if ($user['status'] == 1) {
        header('Location: ' . BASE_URL);
        exit();
    } elseif ($user['status'] == 2) {
        header('Location: ' . BASE_URL . 'allactive');
        exit();
    }