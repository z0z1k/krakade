<?php

use WebSocket\Client;

if(!function_exists('wsMessage')){
    function wsMessage($message) : void{
        $client = new Client(env('WS_URL'));
        $client->text($message);
        $client->close();
    }
}
