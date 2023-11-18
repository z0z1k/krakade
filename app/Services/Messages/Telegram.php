<?php

namespace App\Services\Messages;

use App\Contracts\Messages;

class Telegram implements Messages
{
    public function send($message) : int
    {
        $response = \Telegraph::html($message)->send();

        return $response->telegraphMessageId();
    }

    public function update()
    {

    }

    public function delete()
    {

    }
}