<?php

    const HOST = 'http://localhost';
    const BASE_URL = '/';

    const DB_HOST = '';
    const DB_NAME = '';
    const DB_USER = '';
    const DB_PASS = '';

    define('TELEGRAM_TOKEN', '');
    define('TELEGRAM_CHATID', '');

    include 'core/db.php';
    include 'core/system.php';
    include 'core/arr.php';
    include 'model/users.php';
    include 'model/sessions.php';
    include 'model/orders.php';
    include 'model/tgmessage.php';
    include 'core/auth.php';
    spl_autoload_register(function($class){
        $path = str_replace('\\', '/', $class) . '.php';
        if (file_exists($path)) {
            include_once($path);
        }
    });

    $userName = $user['name'] ?? '';