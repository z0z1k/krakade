<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Orders\Store as OrdersRequest;

use App\Models\Order;
use App\Models\Place;

use DefStudio\Telegraph\Models\TelegraphChat;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;

use App\Enums\Order\Status as OrderStatus;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class Orders extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Gate::allows('courier') ?
            Order::whereNotIn('status', [ OrderStatus::DELIVERED, OrderStatus::CANCELLED ])->get() :
            OrderM::whereIn('place_id', PlaceM::where('user_id', Auth::user()->id)->pluck('id'))
            ->whereNotIn('status', [ OrderStatus::DELIVERED, OrderStatus::CANCELLED ])->get();
        return view('orders.index', [ 'orders' => $orders]);
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
    public function store(OrdersRequest $request)
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
        //$link = Order::findOrFail($id)->status == OrderStatus::COURIER_FOUND ?
        $order = Order::findOrFail($id);
        switch ($order->status) {
            case OrderStatus::CREATED:
                $link = 'orders.show';
                $method = 'get';
                $text = OrderStatus::CREATED->text();
                break;
            case OrderStatus::COURIER_FOUND:
                $link = 'orders.get';
                $method = 'post';
                $text = 'Отримав замовлення';
                break;
            case OrderStatus::TAKEN:
                $link = 'orders.delivered';
                $method = 'post';
                $text = 'Доставлено';
                break;
            default:
                $link = 'orders.show';
                $method = 'get';
                $text = 'Замовлення закрите';
                break;
        }
        return view('orders.show', compact('order', 'link', 'method', 'text'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('orders.edit', [ 'order' => Order::findOrFail($id) ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrdersRequest $request, string $id)
    {
        $request->validated();

        $data = $request->only('client_address', 'client_phone', 'be_ready', 'payment_type', 'comment');
        Order::findOrFail($id)->update($data);

        return to_route('orders.index')->with('message', 'order.updated');
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

    public function get($id)
    {
        Order::findOrFail($id)->update([ 'status' => OrderStatus::TAKEN, 'get_at' => \Carbon\Carbon::now()->toDateTimeString() ]);
        return to_route('orders.show', $id);
    }

    public function delivered($id)
    {
        $order = Order::findOrFail($id);
        \Telegraph::deleteMessage($order->message_id)->send();
        $order->update([ 'status' => OrderStatus::DELIVERED, 'delivered_at' => \Carbon\Carbon::now()->toDateTimeString() ]);
        return to_route('orders.show', $id);
    }

    public function plusTime($id)
    {
        dump(Order::findOrFail($id)->be_ready);
    }

    public function minusTime($id)
    {
        
    }
}
