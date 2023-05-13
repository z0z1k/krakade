<?php
    
    $user = null;
    $token = $_SESSION['token'] ?? $_COOKIE['token'] ?? null;

    if($token !== null) {
        $session = sessionGet($token);
        
        if ($session !== null) {
            $user = userByID($session['id_user']);
        }

        if ($user === null) {
            unset($_SESION['token']);
            setcookie('token', '', time() - 3600, BASE_URL);
        }
    }