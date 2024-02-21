<?php

namespace App\Services\Messages;

use App\Contracts\Messages;

use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;

class Telegram implements Messages
{
    public function send($message) : int
    {
        $response = \Telegraph::html($message)->send();

        return $response->telegraphMessageId();
    }

    public function replyMap($id)
    {
        \Telegraph::reply($id)->location(49.502251,25.6130643)->send();
    }

    public function update()
    {

    }

    public function delete()
    {

    }

    public function attachKeyboard($messageId, $orderId, $text)
    {
        $url = env('APP_URL') . '/orders/take/' . $orderId;

        \Telegraph::replaceKeyboard(
            messageId: $messageId, 
            newKeyboard: Keyboard::make()->buttons([
                Button::make($text)->url($url),
            ])
        )->send();
    }

    public function updateKeyboard($orderId, $messageId, $text)
    {
        $url = env('APP_URL') . '/orders/' . $orderId . '/take';

        \Telegraph::replaceKeyboard(
            messageId: $messageId, 
            newKeyboard: Keyboard::make()->buttons([
                Button::make($text)->url($url),
            ])
        )->send();
    }
}