<?php

namespace App\Actions\Orders;

class PrepareOrderShowForView
{
    public function __invoke($order)
    {
        return $order;
    }
}
