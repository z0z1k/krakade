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

use Carbon\Carbon;

class Orders extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Gate::allows('courier') ?
            Order::whereNotIn('status', [ OrderStatus::DELIVERED, OrderStatus::CANCELLED ])->get() :
            Order::whereIn('place_id', Place::where('user_id', Auth::user()->id)->pluck('id'))
            ->whereNotIn('status', [ OrderStatus::DELIVERED, OrderStatus::CANCELLED ])->get();
        return view('orders.index', compact('orders'));
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

        $message = $this->sendMessage($data);
        $data['message_id'] = $message->telegraphMessageId();
        $id = Order::create($data)->id;

        $this->updateKeyboard($id, $data['message_id'], 'Взяти замовлення');
        $this->wsMessage('order_created');

        return to_route('orders.index')->with('message', 'order.created');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
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
        $order = Order::findOrFail($id);
        $order->update($data);

        \Telegraph::reply($order->message_id)->message("new text")->send();

        $this->wsMessage('order_updated');

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
        if ($order->status != OrderStatus::CREATED) {
            return to_route('orders.show', $id);
        }

        $order->update(['status' => OrderStatus::COURIER_FOUND, 'courier_id' => Auth::user()->id ]);
        $this->updateKeyboard($order->id, $order->message_id, Auth::user()->name);       

        $this->wsMessage('order_updated');
        return to_route('orders.show', $id);
    }

    public function get($id)
    {
        Order::findOrFail($id)->update([ 'status' => OrderStatus::TAKEN, 'get_at' => Carbon::now()->toDateTimeString() ]);
        
        $this->wsMessage('order_updated'); 
           
        return to_route('orders.show', $id);
    }

    public function delivered($id)
    {
        $order = Order::findOrFail($id);
        \Telegraph::deleteMessage($order->message_id)->send();
        $order->update([ 'status' => OrderStatus::DELIVERED, 'delivered_at' => Carbon::now()->toDateTimeString() ]);
        
        $this->wsMessage('order_updated');
        
        return to_route('orders.show', $id);
    }

    public function plusTime($id)
    {
        $order = Order::findOrFail($id);
        $order->update([ 'be_ready' => Carbon::parse($order->be_ready)->addMinutes(5)->toTimeString() ]);
        
        $this->wsMessage('order_updated');
        
        return to_route('orders.index');
    }

    public function minusTime($id)
    {
        $order = Order::findOrFail($id);
        $order->update([ 'be_ready' => Carbon::parse($order->be_ready)->subMinutes(5)->toTimeString() ]);
        
        $this->wsMessage('order_updated');
        
        return to_route('orders.index');
    }

    protected function sendMessage($data)
    {
        $response = \Telegraph::html($this->generateMessage($data))->send();

        return $response;
    }

    protected function generateMessage($data)
    {
        $message = "<strong>" . Place::findOrFail($data['place_id'])->name . " ⇾ " . $data['client_address'] ."</strong>";
        $message .= "\n{$data['be_ready']}, {$data['client_phone']}, {$data['payment_type']}\n{$data['comment']}";

        return $message;
    }

    protected function updateKeyboard($orderId, $messageId, $text)
    {
        $url = env('APP_URL') . '/orders/take/' . $orderId;

        \Telegraph::replaceKeyboard(
            messageId: $messageId, 
            newKeyboard: Keyboard::make()->buttons([
                Button::make($text)->url($url),
            ])
        )->send();
    }

    protected function wsMessage($message)
    {
        $client = new \WebSocket\Client(env('WS_URL'));
        $client->text($message);
        $client->close();
    }
}
