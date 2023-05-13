<?php

    const HOST = 'http://localhost';
    const BASE_URL = '/';

    const DB_HOST = 'localhost';
    const DB_NAME = 'delivery';
    const DB_USER = 'root';
    const DB_PASS = '';

    define('TELEGRAM_TOKEN', '6151465890:AAHxUqv4PBZP6j9YRDLZOj_dT5IxD8ymQrA');
    define('TELEGRAM_CHATID', '-1001733114623');

    include 'core/db.php';
    include 'core/system.php';
    include 'core/arr.php';
    include 'model/users.php';
    include 'model/sessions.php';
    include 'model/orders.php';
    include 'model/tgmessage.php';
    include 'core/auth.php';