<?php

namespace App\Http\Telegraph;

class TgHandler extends \DefStudio\Telegraph\Handlers\WebhookHandler
{
    public function start()
    {
        $this->chat->html('Hi')->send();
    }
}