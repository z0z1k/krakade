<?php

if(!function_exists('wsMessage')){
    function wsMessage($message) {
        $client = new \WebSocket\Client(env('WS_URL'));
        $client->text($message);
        $client->close();
    }
}