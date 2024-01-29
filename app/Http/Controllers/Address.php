<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Address extends Controller
{
    public function parse(Request $request)
    {
        $url = 'https://nominatim.openstreetmap.org/search?q=' . str_replace(' ', '+', $request->city) .'+' . str_replace(' ', '+', $request->street) .'&format=json';
        $response = Http::get($url)[0];
        $location = $response['lat'] .',' . $response['lon'];
        return $location;
    }

    public function calc($firstLocation, $secondLocation)
    {
        //$url = "http://192.168.0.116:5000/route/v1/driving/{$firstLocation};{$secondLocation}";
        $url = "https://api.geoapify.com/v1/routing?waypoints={$firstLocation}|{$secondLocation}&mode=drive&apiKey=593087ab22f34ff9864cdc6579caf776";
        $response = Http::get($url)['features']['0']['properties']['distance'];
        return $response;
    }
}
