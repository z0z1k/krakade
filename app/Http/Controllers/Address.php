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
        $location = $response['lon'] .',' . $response['lat'];
        return $location;
    }

    public function calc($firstLocation, $secondLocation)
    {
        $url = "http://osrm.krkd.uno/route/v1/driving/$firstLocation;$secondLocation";
        $response = Http::get($url)['routes'][0]['distance'];
        return $response;
    }
}
