<?php

namespace App\Actions\Orders;

use Carbon\Carbon;

use App\Models\Place;
use App\Models\City;

class GenerateMessage
{
    public function __invoke($data) {
        $city = City::findOrFail($data['city_id'])->city;
        $city = $city == env('CITY') ? '' : $city . ', ';
        $address_info = str_contains($data['address_info'], 'кв') ? $data['address_info'] : 'кв ' . $data['address_info'];
        $payment = $data['payment'] ? "кур'єр платить " .$data['payment'] . 'грн' : 'без оплати';
        $problem = $data['problem'] ?? '';
        $approximate_ready_at = Carbon::parse($data['approximate_ready_at'])->format('H:i');
        
        $address = $city . $data['address'] . ', ' .$address_info;
        $message = "<strong>" . Place::findOrFail($data['place_id'])->name . " ⇾ $address</strong>";
        $message .= "\n{$approximate_ready_at}, {$data['client_phone']}, {$payment}\n{$problem}\n{$data['comment']}\nДоставка:{$data['price']}грн";

        return $message;
    }
}