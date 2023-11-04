<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Orders\Store as StoreRequest;

use App\Models\Order;
use App\Models\Place;

use DefStudio\Telegraph\Models\TelegraphChat;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;

use App\Enums\Order\Status as OrderStatus;

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
        $chat = TelegraphChat::find(1);

        $message = "<strong>" . Place::findOrFail($data['place_id'])->name . " ⇾ " . $data['client_address'] ."</strong>";
        $message .= "\n{$data['be_ready']}, {$data['client_phone']}, {$data['payment_type']}\n{$data['comment']}";
        
        $url = env('APP_URL') . '/orders/take';

        $response = $chat->html($message)->keyboard(Keyboard::make()->buttons([
            Button::make('Взяти замовлення')->url($url),
        ]))->send();
        
        if (!$response->telegraphOk()) {            
            return redirect()->back()->with('message', 'order.error');
        }

        $data['message_id'] = $response->telegraphMessageId();
        Order::create($data);
        return redirect()->route('orders.index')->with('message', 'order.created');

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

    public function take()
    {
        return view('orders.take');
    }
}
