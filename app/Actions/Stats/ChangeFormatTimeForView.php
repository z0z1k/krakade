<?php

namespace App\Actions\Stats;

use Carbon\Carbon;

class ChangeFormatTimeForView
{
    public function __invoke($orders)
    {
        $orders->averageDeliveryTime = 0;
        foreach($orders as $order) {
            $takenAt =Carbon::parse($order->taken_at);
            $approximateReadyAt = Carbon::parse($order->approximate_ready_at);
            $deliveredAt = Carbon::parse($order->delivered_at);

            $order->date = Carbon::parse($order->approximate_ready_at)->format('d.m.y');
            $order->approximate_ready_at = $approximateReadyAt->format('H:i');
            $order->taken_at = $takenAt->format('H:i');
            $order->delivered_at = $deliveredAt->format('H:i');

            $order->deliveryTime = $takenAt->diffInMinutes($deliveredAt);
            $orders->averageDeliveryTime += $order->deliveryTime;
        }
        $orders->averageDeliveryTime = $orders->count() > 0 ? (round($orders->averageDeliveryTime / $orders->count())) : 0;

        return $orders;
    }
}