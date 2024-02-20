<?php

namespace App\Actions\Orders;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use Carbon\Carbon;

use App\Models\User;
use App\Models\City;

class CalcPriceForDistance
{
    public function __invoke($prices, $request)
    {
        if (array_key_exists('default', $prices)) {
            $price = $prices['default'];
        } else {
            foreach ($prices as $distance => $value) {
                //dd($request->distance);
                $price = false;
                if ($request->distance <= floatval(str_replace(",", ".", $distance)) * 1000) {
                    $price = $value;
                    break;
                }
            }
        } //yes, foreach is bad here

        if (!$price) {
            
            $price = end($prices);
        }

        return $price;
    }
}