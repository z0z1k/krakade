<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Session extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store()
    {

    }

    public function exit()
    {

    }

    public function destroy()
    {

    }

}
