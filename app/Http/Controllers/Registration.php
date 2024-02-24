<?php

namespace App\Http\Controllers;

use App\Http\Requests\Registration\Store as StoreRequest;

use App\Models\User;
use App\Models\Role;
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

        $role = Role::where('name', $request->userRole)->first();
        User::findOrFail(Auth::user()->id)->roles()->sync($role->id);

        if ($role->name == 'place') {
            return to_route('places.create');
        } else {
            return to_route('profile.info');
        }
    }
}
