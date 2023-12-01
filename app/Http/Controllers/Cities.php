<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\City;

class Cities extends Controller
{
    public function index()
    {
        return view('cities.index', [ 'cities' => City::all() ]);
    }

    public function update(Request $request)
    {
        foreach ($request->except('_token', '_method') as $id_distance => $value) {
            $data[stristr($id_distance, '_', true)][mb_substr(stristr($id_distance, '_'), 1)] = $value;
        }

        foreach ($data as $id => $value) {
            City::findOrFail($id)->update(['price' => $value]);
        }

        return to_route('cities.index');
    }
}
