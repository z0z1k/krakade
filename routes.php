<?php

return (function()
{
    $intGT0 = '[1-9]+\d*';
	$normUrl = '[0-9aA-zZ_-]+';

    return [
        [
            'name' => '/^$/',
            'controller' => 'orders/active',
        ],
        [
            'name' => '/^auth\/?$/',
            'controller' => 'auth/login',
        ],
        [
            'name' => '/^auth\/new\/?$/',
            'controller' => 'auth/createUser',
        ],
        [
            'name' => '/^logout\/?$/',
            'controller' => 'auth/logout',
        ],
        [
            'name' => "/^active\/($intGT0)\/?$/",
            'controller' => 'orders/setActive',
            'params' => ['id' => 1]
        ],
        [
            'name' => "/^ready\/($intGT0)\/?$/",
            'controller' => 'orders/setReady',
            'params' => ['id' => 1]
        ],
        [
            'name' => '/^complete\/?$/',
            'controller' => 'orders/active'
        ],
    ];
}) ();