<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Registration\Store as StoreRequest;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Registration extends Controller
{
    public function create()
    {
        return view('registration.create');
    }

    public function store(StoreRequest $request)
    {
        $request->validated();

        $data = $request->only('name', 'email', 'phone', 'password');
        $user = User::create($data);
        Auth::login($user);

        return redirect()->route('profile.info');
    }
}
