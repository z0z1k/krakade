<?php
    session_start();

    use Models\Order;
    use System\User;

    include_once 'init.php';
    include_once 'spl.php';

    $user = User::getInstance();

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

    $userName = $user->getName() ?? '';

    $logName = 'logs/' . date("d.m.Y", time());
    $logData = date("G:i:s", time()) . '|' . $_SERVER['REMOTE_ADDR'] . '|' . $_SERVER['HTTP_USER_AGENT'] . '|' . substr($_SERVER['QUERY_STRING'], 15) . '|' . $userName . "\n";
    file_put_contents($logName, $logData, FILE_APPEND);


    $html = template('base/v_main', [
        'title' => $pageTitle,
        'content' => $pageContent,
        'userName' => $userName,
        'canonical' => $pageCanonical,
        'errors' => $errors
    ]);

    $orders = Order::getInstance();
    
    var_dump($orders->active());

    echo $html;