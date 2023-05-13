<?php

    $createErr = false;

     if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if ($_POST['password'] === $_POST['passwordR']) {

            $params = extractFields($_POST, ['login', 'password', 'email', 'name', 'address', 'number', ]);
            $params['password'] = password_hash($params['password'], PASSWORD_BCRYPT);
            createUser($params);

            header('Location: ' . BASE_URL . 'auth');
            exit();
        } else {
            $createErr = true;
        }

    } else {

    }

    $pageTitle = 'Додати заклад';
    $pageContent = template('auth/v_createUser', [
        'createErr' => $createErr,
    ]);