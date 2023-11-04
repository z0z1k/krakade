<?php

namespace App\Http\Telegraph;


use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;

class TgHandler extends \DefStudio\Telegraph\Handlers\WebhookHandler
{
    public function start()
    {
        $this->chat->html('Hi')->send();
    }
}