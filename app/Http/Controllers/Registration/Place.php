<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Place extends Controller
{
    public function create()
    {
        return view('registration.place.create');
    }
}
