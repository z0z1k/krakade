<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Place;

class Places extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('places.index', [ 'places' => Place::where('user_id', Auth::user()->id)->get() ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('places.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {        
        $data = $request->only('name', 'address', 'phone', 'email') + [ 'user_id' => $request->user()->id ];
        Place::create($data);

        return redirect()->route('places.index');
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

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
