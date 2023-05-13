<?php
    header("HTTP/1.0 404 Not Found");

    $pageTitle = 'Помилка 404';
    $pageContent = template('errors/e404');