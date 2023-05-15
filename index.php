<?php
    session_start();

    include_once 'init.php';

    $pageCanonical = HOST . BASE_URL;
    $uri = $_SERVER['REQUEST_URI'];
    $badUrl = BASE_URL . 'index.php';

    if(strpos($uri, $badUrl) === 0){
        $cname = 'errors/e404';
    }
    else{
        $routes = include('routes.php');
        $url = $_GET['querysystemurl'] ?? '';
        
        $routerRes = parseUrl($url, $routes);
        $cname = $routerRes['controller'];
        define('URL_PARAMS', $routerRes['params']);

        $urlLen = strlen($url);

        if($urlLen > 0 && $url[$urlLen - 1] == '/'){
            $url = substr($url, 0, $urlLen - 1);
        }

        $pageCanonical .= $url;
    }

    $path = "controllers/$cname.php";
    $pageTitle = $pageContent = '';
    $errors = [];

    if(!file_exists($path)){
        $cname = 'errors/e404';
        $path = "controllers/$cname.php";
    }

    include_once($path);

    if (isset($user['name'])) {
        $name = $user['name'];
    } else {
        $name = '';
    }

    $logName = 'logs/' . date("d.m.Y", time());
    $logData = $_SERVER['REMOTE_ADDR'] . '|' . $_SERVER['HTTP_USER_AGENT'] . '|' . $_SERVER['QUERY_STRING'] . '|' . $name . "\n";
    file_put_contents($logName, $logData, FILE_APPEND);


    $html = template('base/v_main', [
        'title' => $pageTitle,
        'content' => $pageContent,
        'username' => $name,
        'canonical' => $pageCanonical,
        'errors' => $errors
    ]);

    echo $html;