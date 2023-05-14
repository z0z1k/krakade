<?php

    const HOST = 'http://localhost';
    const BASE_URL = '/';

    const DB_HOST = 'localhost';
    const DB_NAME = 'delivery';
    const DB_USER = 'root';
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
