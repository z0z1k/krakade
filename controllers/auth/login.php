<?php

    $authErr = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $login = trim($_POST['login']);
        $password = trim($_POST['password']);
        $remember = isset($_POST['remember']);

        $user = usersOne($login);
        if ($user !== null && password_verify($password, $user['password'])) {
            $token = substr(bin2hex(random_bytes(128)), 0, 128);
            sessionAdd($user['id_user'], $token);
            $_SESSION['token'] = $token;

            if ($remember) {
                setcookie('token', $token, time() + 3600 * 24 * 31, BASE_URL);
            }

            header('Location: ' . BASE_URL);
            exit();
        } else {
            $authErr = 1;
        }
    }

    $pageTitle = 'Авторизація';
    $pageContent = template('auth/v_login', [
        'authErr' => $authErr
    ]);