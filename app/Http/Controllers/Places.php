<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Places\Store as StoreRequest;

use Illuminate\Support\Facades\Http;

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
    public function store(StoreRequest $request)
    {
        $request->validated();

        $url = 'https://nominatim.openstreetmap.org/search?q=Тернопіль+' . str_replace(' ', '+', $request->address) .'&format=json';
        $response = Http::get($url);
        $response = json_decode($response)[0];

        $location = $response->lat .',' . $response->lon;

        $data = $request->only('name', 'address', 'description') + [ 'user_id' => $request->user()->id, 'location' => $location ];
        Place::create($data);

        return redirect()->route('places.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //return view('places.show', [ 'place' => Place::findOrFail($id) ]);
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
