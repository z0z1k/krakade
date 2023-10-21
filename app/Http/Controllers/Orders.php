<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Orders\Store as StoreRequest;

use App\Models\Order;
use App\Models\Place;


class Orders extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('orders.index', [ 'orders' => Order::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($place)
    {
        return view('orders.create', [ 'place' => Place::findOrFail($place)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->only('client_address', 'client_phone', 'be_ready', 'payment_type', 'comment', 'place_id');
        $data['message_id'] = 1;

        Order::create($data);
        return redirect()->route('orders.index');
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
        //
    }
}
