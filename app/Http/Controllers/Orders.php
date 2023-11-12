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
        $orders = Gate::allows('courier') ? Order::activeCourier()->get() : Order::activePlace()->get();
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
        $data['message'] = $this->generateMessage($data);
        $message = $this->sendMessage($data['message']);
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

        $order = Order::findOrFail($id);

        $data = $request->only('client_address', 'client_phone', 'be_ready', 'payment_type', 'comment');
        $data['message'] = $this->generateMessage($data + [ 'place_id' => $order->place_id]);
        if(!str_contains($data['message'], 'Оновлення!')){
            $data['message']  = 'Оновлення! ' . $data['message'];
        }
        $this->deleteMessage($order->message_id);
        $message = $this->sendMessage($data['message']);
        $data['message_id'] = $message->telegraphMessageId();
        $text = $order->courier->name ?? $order->status->text();
        $this->updateKeyboard($id, $data['message_id'], $text);
        $order->update($data);

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
        $order = Order::findOrFail($id);
        $this->updateKeyboard($order->id, $order->message_id, OrderStatus::TAKEN->text());
        $order->update([ 'status' => OrderStatus::TAKEN, 'get_at' => Carbon::now()->toDateTimeString() ]);
                $this->wsMessage('order_updated'); 
           
        return to_route('orders.show', $id);
    }

    public function delivered($id)
    {
        $order = Order::findOrFail($id);
        $this->deleteMessage($order->message_id);
        $order->update([ 'status' => OrderStatus::DELIVERED, 'delivered_at' => Carbon::now()->toDateTimeString() ]);
        
        $this->wsMessage('order_updated');
        
        return to_route('orders.show', $id);
    }

    public function plusTime($id)
    {
        $this->updateTime($id, 'addMinutes');
    }

    public function minusTime($id)
    {
        $this->updateTime($id, 'subMinutes');
    }

    public function cancel($id)
    {
        $order = Order::findOrFail($id);
        $this->deleteMessage($order->message_id);
        $order->update([ 'status' => OrderStatus::CANCELLED ]);
        
        $this->wsMessage('order_updated');
        
        return to_route('orders.index')->with('message', 'order.cancelled');
    }

    protected function updateTime($id, $method, $count = 5)
    {
        $order = Order::findOrFail($id);        
        $time = Carbon::parse($order->be_ready)->$method($count)->format('H:i');

        $message = preg_replace("/([01]?[0-9]|2[0-3])\:+[0-5][0-9]/", $time, $order->message);
        if(!str_contains($message, 'Оновлення!')){
            $message  = 'Оновлення! ' . $message;
        }
        $this->deleteMessage($order->message_id);
        $response = $this->sendMessage($message);
        $text = $order->courier->name ?? $order->status->text();
        $this->updateKeyboard($id, $response->telegraphMessageId(), $text);
     
        $order->update([ 'be_ready' =>  $time, 'message' => $message, 'message_id' => $response->telegraphMessageId()]);
        $this->wsMessage('order_updated');
        
        return to_route('orders.index');
    }

    protected function sendMessage($message)
    {
        $response = \Telegraph::html($message)->send();

        return $response;
    }

    protected function generateMessage($data)
    {
        $message = "<strong>" . Place::findOrFail($data['place_id'])->name . " ⇾ " . $data['client_address'] ."</strong>";
        $message .= "\n{$data['be_ready']}, {$data['client_phone']}, {$data['payment_type']}\n{$data['comment']}";

        return $message;
    }

    public function replyMessage($id, $reply)
    {
        \Telegraph::message($reply)->reply($id)->send();
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

    protected function deleteMessage($id)
    {
        \Telegraph::deleteMessage($id)->send();   
    }

    protected function wsMessage($message)
    {
        $client = new \WebSocket\Client(env('WS_URL'));
        $client->text($message);
        $client->close();
    }
}
