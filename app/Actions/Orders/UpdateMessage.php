<?php

namespace App\Actions\Orders;

class UpdateMessage
{
    public function __invoke($message)
    {
        if(!str_contains($message, 'Оновлення!')){
            $message  = 'Оновлення! ' . $message;
        }
        
        return $message;
    }
}