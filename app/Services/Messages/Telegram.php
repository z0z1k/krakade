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

    public function sendMap($loc)
    {
        \Telegraph::location(49.502251,25.6130643)->send();
    }

    public function update()
    {

    }

    public function delete()
    {

    }
}