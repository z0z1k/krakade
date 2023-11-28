<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Orders\Store as OrdersRequest;

use App\Models\Order;
use App\Models\Place;
use App\Models\City;
use App\Models\User;

use DefStudio\Telegraph\Models\TelegraphChat;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;

use App\Enums\Order\Status as OrderStatus;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use Carbon\Carbon;

use App\Contracts\Messages;
class Orders extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {        
        $courier = Gate::allows('courier');
        $place = Gate::allows('place');
        $orders = $courier ? Order::activeCourier()->get() : Order::activePlace()->get();     

        $orders = $this->editOrdersForView($orders);

        $title = 'Активні замовлення';
        return view('orders.index', compact('orders', 'title', 'courier', 'place'));
    }

    public function cancelled()
    {
        $orders = Order::cancelled()->get();
        $title = 'Скасовані замовлення';
        $courier = Gate::allows('courier') ? true : false;
        $place = Gate::allows('place') ? true : false;
        return view('orders.cancelled', compact('orders', 'title', 'courier', 'place'));
    }

    public function delivered()
    {
        $orders = Gate::allows('courier') ? Order::deliveredAll()->get() : Order::deliveredPlace()->get();
        return view('orders.delivered', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($place)
    {
        return view('orders.create', [ 'place' => Place::findOrFail($place), 'cities' => City::all()->pluck('city', 'id') ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrdersRequest $request, Messages $messages)
    {
        $data = $request->only(
            'place_id',
            'location',
            'client_phone',
            'payment',
            'problem',
            'comment'
        ) + [
            'approximate_ready_at' => Carbon::parse($request->approximate_ready_at)->toDateTimeString(),
            'city_id' => $request->city,
            'address' => $request->client_address,
            'address_info' => $request->client_address_info,
            'prepared_at' => Carbon::parse($request->approximate_ready_at)->toDateTimeString(),
        ];

        $data['message_id'] = $messages->send($this->generateMessage($data));
        $id = Order::create($data)->id;

        $messages->attachKeyboard($id, $data['message_id'], 'Взяти замовлення');
        $this->wsMessage('order_created');

        return to_route('orders.index')->with('message', 'order.created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::findOrFail($id);
        $order['date'] = Carbon::parse($order->created_at)->format('d.m.y D');
        $order->be_ready = Carbon::parse($order->be_ready)->format('H:i');
        $order->ready_at = Carbon::parse($order->ready_at)->format('H:i');
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
                $link = 'orders.setDelivered';
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

        $order->update(['status' => OrderStatus::COURIER_FOUND, 'courier_id' => Auth::user()->id, 'courier_arriving_time' => $order->be_ready]);
        $this->updateKeyboard($order->id, $order->message_id, Auth::user()->name);       

        $this->wsMessage('order_updated');
        return to_route('orders.show', $id);
    }

    public function get($id)
    {
        $order = Order::findOrFail($id);
        $this->updateKeyboard($order->id, $order->message_id, OrderStatus::TAKEN->text());
        $order->update([ 'status' => OrderStatus::TAKEN, 'get_at' => Carbon::now('Europe/Kyiv')->toDateTimeString() ]);
                $this->wsMessage('order_updated'); 
           
        return to_route('orders.show', $id);
    }

    public function setDelivered($id)
    {
        $order = Order::findOrFail($id);
        $this->deleteMessage($order->message_id);
        $order->update([ 'status' => OrderStatus::DELIVERED, 'delivered_at' => Carbon::now('Europe/Kyiv')->toDateTimeString() ]);
        
        $this->wsMessage('order_updated');
        
        return to_route('orders.show', $id);
    }

    public function ready($id)
    {
        $order = Order::findOrFail($id);

        $message = preg_replace("/([01]?[0-9]|2[0-3])\:+[0-5][0-9]/", config('constants.orders.ready'), $order->message);
        $this->deleteMessage($order->message_id);
        $response = $this->sendMessage($message);
        $text = $order->courier->name ?? $order->status->text();
        $this->updateKeyboard($id, $response->telegraphMessageId(), $text);
     
        $order->update(['ready_at' => Carbon::now('Europe/Kyiv')->format('H:i'), 'message' => $message, 'message_id' => $response->telegraphMessageId(), 'ready' => true]);
        $this->wsMessage('order_updated');
        
        return to_route('orders.index');
    }

    public function plusTime($id)
    {
        $this->updateTime($id, 'addMinutes');
    }

    public function minusTime($id)
    {
        $this->updateTime($id, 'subMinutes');
    }

    public function courierPlusTime($id)
    {
        $this->courierUpdateTime($id, 'addMinutes');
    }

    public function courierMinusTime($id)
    {
        $this->courierUpdateTime($id, 'subMinutes');
    }

    public function cancel($id)
    {
        $order = Order::findOrFail($id);
        $this->deleteMessage($order->message_id);
        $order->update([ 'status' => OrderStatus::CANCELLED ]);
        
        $this->wsMessage('order_updated');
        
        return to_route('orders.index')->with('message', 'order.cancelled');
    }

    protected function courierUpdateTime($id, $method, $count = 5)
    {
        $order = Order::findOrFail($id);        
        $time = Carbon::parse($order->courier_arriving_time)->$method($count)->format('H:i');

        $order->update(['courier_arriving_time' => $time]);
        $this->wsMessage('order_updated');

        return to_route('orders.index');
    }

    protected function updateTime($id, $method, $count = 5)
    {
        $order = Order::findOrFail($id);        
        $time = Carbon::parse($order->ready_at)->$method($count)->format('H:i');

        $message = preg_replace("/([01]?[0-9]|2[0-3])\:+[0-5][0-9]/", $time, $order->message);
        if(!str_contains($message, 'Оновлення!')){
            $message  = 'Оновлення! ' . $message;
        }
        $this->deleteMessage($order->message_id);
        $response = $this->sendMessage($message);
        $text = $order->courier->name ?? $order->status->text();
        $this->updateKeyboard($id, $response->telegraphMessageId(), $text);
     
        $order->update([ 'ready_at' =>  $time, 'message' => $message, 'message_id' => $response->telegraphMessageId()]);
        $this->wsMessage('order_updated');
        
        return to_route('orders.index');
    }

    protected function editOrdersForView($orders)
    {
        foreach($orders as $order) {
            $order['address'] = $this->parseAddress($order);
            if ($order->approximate_courier_arrived_at) {
                $order->approximate_courier_arrived_at = Carbon::parse($order->approximate_courier_arrived_at)->format('H:i');
            } //yes, this is bad
            if ($order->payment) {
                $order->payment .= '₴';
            } else {
                $order->payment = 'Оплата не потрібна';   
            }//yes, this is bad again
            $order['can_edit'] = Gate::allows('change-order-status', $order);            
            $order->approximate_ready_at = Carbon::parse($order->approximate_ready_at)->format('H:i'); //why created_at is carbon object, but this string?
            $order->prepared_at = Carbon::parse($order->prepared_at)->format('H:i');

            $order['courier'] = User::where('id', $order->courier_id)->first(); //fix this
            
        }

        return $orders;
    }

    protected function sendMessage($message)
    {
        $response = \Telegraph::html($message)->send();

        return $response;
    }

    protected function parseAddress($order)
    {
        $city = City::findOrFail($order->city_id)->city;
        $city = $city != 'Тернопіль' ?? '';
        $address_info = str_contains($order->address_info, 'кв') ? $order->address_info : 'кв ' . $order->address_info;

        return "$city $order->address, $address_info";
    }

    protected function generateMessage($data)
    {
        $city = City::findOrFail($data['city_id'])->city == 'Тернопіль' ? '' : City::findOrFail($data['city_id'])->city;
        $address_info = str_contains($data['address_info'], 'кв') ? $data['address_info'] : 'кв ' . $data['address_info'];
        $payment = $data['payment'] ?? '';
        $problem = $data['problem'] ?? '';
        $approximate_ready_at = Carbon::parse($data['approximate_ready_at'])->format('H:i');
        
        $address = "$city, {$data['address']}, $address_info";
        $message = "<strong>" . Place::findOrFail($data['place_id'])->name . " ⇾ {$city} $address</strong>";
        $message .= "\n{$approximate_ready_at}, {$data['client_phone']}, {$payment}\n{$problem}\n{$data['comment']}";

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
