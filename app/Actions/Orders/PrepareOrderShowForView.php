<?php

namespace App\Actions\Orders;

use Carbon\Carbon;

class PrepareOrderShowForView
{
    public function __invoke($order)
    {
        $order->date = Carbon::parse($order->created_at)->format('d.m.y D');
        $order->be_ready = Carbon::parse($order->be_ready)->format('H:i');
        $order->ready_at = Carbon::parse($order->ready_at)->format('H:i');

        return $order;
    }
}
