<?php

namespace App\Actions\Orders;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use Carbon\Carbon;

use App\Models\User;
use App\Models\City;

class PrepareOrdersForView
{
    public function __invoke($orders) {
        foreach($orders as $order) {
            $order->date = Carbon::parse($order->created_at)->format('d.m.y');
            $order['address'] = $this->parseAddress($order);
            if ($order->approximate_courier_arrived_at) {
                $order->approximate_courier_arrived_at = Carbon::parse($order->approximate_courier_arrived_at)->format('H:i');
            } //yes, this is bad
            if ($order->payment) {
                $order->payment .= '₴';
            } else {
                $order->payment = 'Оплата не потрібна';
            }//yes, this is bad again
            $order['can_edit'] = Gate::allows('change-order-status', $order);
            $order->approximate_ready_at = Carbon::parse($order->approximate_ready_at)->format('H:i'); //why created_at is carbon object, but this string?
            $order->prepared_at = Carbon::parse($order->prepared_at)->format('H:i');
            if ($order->taken_at) {
                $order->taken_at = Carbon::parse($order->taken_at)->format('H:i');
            }

        }

    return $orders;

    }

    public function parseAddress($order)
    {
        $city = City::findOrFail($order->city_id)->city;
        $city = $city != env('CITY') ?? '';
        $address_info = str_contains($order->address_info, 'кв') ? $order->address_info : 'кв ' . $order->address_info;

        return "$city $order->address, $address_info";
    }
}
