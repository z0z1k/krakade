<?php

namespace App\Actions\Orders;

use App\Models\City;
use Carbon\Carbon;

class PrepareOrderForView
{
    public function __invoke($order)
    {
        $order->date = Carbon::parse($order->created_at)->format('d.m.y D');
        $order->approximate_ready_at = Carbon::parse($order->approximate_ready_at)->format('H:i');
        $order->taken_at = $order->taken_at ? Carbon::parse($order->taken_at)->format('H:i') : '';
        $order->delivered_at = $order->delivered_at ? Carbon::parse($order->delivered_at)->format('H:i') : '';
        $city = City::findOrFail($order->city_id)->city;
        $order->client_address = "$city, $order->address $order->address_info";

        return $order;
    }
}

