<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Users\Role as saveRolesRequest;

use App\Models\User;
use App\Models\Role;
use App\Models\Order;

class Users extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        foreach($users as &$user) {
            $user['orders'] = Order::where('courier_id', $user->id)->count();
        }
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    
    }

    public function roles($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::orderBy('id')->get();

        return view('users.roles', compact('user', 'roles'));
    }

    public function saveRoles(saveRolesRequest $request, $id)
    {
        User::findOrFail($id)->roles()->sync($request->roles);
        return redirect()->route('users.index');
    }
}
