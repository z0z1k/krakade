<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\Profile\Update as UpdateRequest;
use App\Models\User;

class Info extends Controller
{
    public function show()
    {
        return view('profile.show', [ 'user' => Auth::user()]);
    }

    public function update(UpdateRequest $request)
    {
        $user = Auth::user();
        $data = $request->only('email', 'name');
        $user->update($data);

        return redirect()->route('profile.info');
    }
}
