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

use Illuminate\Support\Facades\Auth;

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

        $message = "<strong>" . Place::findOrFail($data['place_id'])->name . " ⇾ " . $data['client_address'] ."</strong>";
        $message .= "\n{$data['be_ready']}, {$data['client_phone']}, {$data['payment_type']}\n{$data['comment']}";
        
        $url = env('APP_URL') . '/orders/take/';

        $response = \Telegraph::html($message)->keyboard(Keyboard::make()->buttons([
            Button::make('Взяти замовлення')->url($url),
        ]))->send();

        if (!$response->telegraphOk()) {            
            return redirect()->back()->with('message', 'order.error');
        }

        $data['message_id'] = $response->telegraphMessageId();
        $id = Order::create($data)->id;

        $url .= $id;

        \Telegraph::replaceKeyboard(
            messageId: $data['message_id'], 
            newKeyboard: Keyboard::make()->buttons([
                Button::make('Взяти замовлення')->url($url),
            ])
        )->send();

        return redirect()->route('orders.index')->with('message', 'order.created');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('orders.show', [ 'order' => Order::findOrFail($id) ]);
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

    public function take($id)
    {
        $order = Order::findOrFail($id);
        if ($order->status == OrderStatus::CREATED) {

            dd(Auth::user()->id);
            $order->update(['status' => OrderStatus::COURIER_FOUND, 'courier_id' => Auth::user()->id ]);

            $url = env('APP_URL') . "/orders/$id/";
            
            \Telegraph::replaceKeyboard(
                messageId: $order->message_id, 
                newKeyboard: Keyboard::make()->buttons([
                    Button::make(Auth::user()->name)->url($url),
                ])
            )->send();
       }

        return to_route('orders.show', $id);
    }
}
