<?php

namespace App\Http\Controllers;

use App\Http\Requests\Orders\Store as OrdersRequest;

use App\Models\Order;
use App\Models\Place;
use App\Models\City;

use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;

use App\Enums\Order\Status as OrderStatus;

use App\Actions\Orders\PrepareOrdersForView;
use App\Actions\Orders\PrepareOrderForView;
use App\Actions\Orders\GenerateMessage;
use App\Actions\Orders\CalcPriceForDistance;
use App\Actions\Orders\UpdateMessage;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use Carbon\Carbon;

use App\Contracts\Messages;
class Orders extends Controller
{
    public function index(PrepareOrdersForView $prepareOrdersForView)
    {
        $courier = Gate::allows('courier');
        $place = Gate::allows('place');
        $orders = $courier ? Order::activeCourier()->get() : Order::activePlace()->get();

        $orders = $prepareOrdersForView($orders);

        $title = 'Активні замовлення';
        return view('orders.index', compact('orders', 'title', 'courier', 'place'));
    }

    public function cancelled(PrepareOrdersForView $prepareOrdersForView)
    {
        $orders = $prepareOrdersForView(Order::cancelled()->get());
        return view('orders.cancelled', [ 'orders' => $orders, 'title' => 'Скасовані замовлення']);
    }

    public function delivered(PrepareOrdersForView $prepareOrdersForView)
    {
        $orders = $prepareOrdersForView(Gate::allows('courier') ? Order::deliveredAll()->get() : Order::deliveredPlace()->get());
        return view('orders.delivered', compact('orders'));
    }

    public function create($place)
    {
        return view('orders.create', [ 'place' => Place::findOrFail($place), 'cities' => City::all()->pluck('city', 'id') ]);
    }

    public function store(OrdersRequest $request, Messages $messages, GenerateMessage $generateMessage, CalcPriceForDistance $calcPriceForDistance)
    {
        $price = $calcPriceForDistance(City::find($request->city)->price, $request);

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
            'price' => $price,
        ];

        $data['message'] = $generateMessage($data);
        $data['message_id'] = $messages->send($data['message']);
        $id = Order::create($data)->id;


        $messages->updateKeyboard($id, $data['message_id'], 'Взяти замовлення');
        wsMessage('order_created');

        return to_route('orders.index')->with('message', 'order.created');
    }

    public function show(string $id, PrepareOrderForView $prepareOrderForView)
    {
        return view('orders.show', [ 'order' => $prepareOrderForView(Order::findOrFail($id)) ]);
    }

    public function edit(string $id)
    {
        return view('orders.edit', [ 'order' => Order::findOrFail($id) ]);
    }

    public function take($id, Messages $messages)
    {
        $order = Order::findOrFail($id);
        if ($order->status != OrderStatus::CREATED) {
            return to_route('orders.show', $id);
        }

        $order->update(['status' => OrderStatus::COURIER_FOUND, 'courier_id' => Auth::user()->id, 'approximate_courier_arrived_at' => $order->prepared_at]);
        $messages->updateKeyboard($order->id, $order->message_id, Auth::user()->name);

        wsMessage('order_updated');
        return to_route('orders.index');
    }

    public function changeCourier($id, Messages $message)
    {
        $order = Order::findOrFail($id);
        if (Gate::allows('change-order-status', $order) && $order->status == OrderStatus::COURIER_FOUND) {
            $order->update([
                'status' => OrderStatus::CREATED,
                'courier_id' => null,
                'approximate_courier_arrived_at' => null,
            ]);

            $messages->updateKeyboard($id, $order->id, 'Взяти замовлення');
            wsMessage('order_updated');
        }

        return to_route('orders.index');
    }

    public function get($id, Messages $messages)
    {
        $order = Order::findOrFail($id);
        $messages->updateKeyboard($order->id, $order->message_id, OrderStatus::TAKEN->text());
        $data = ['status' => OrderStatus::TAKEN, 'taken_at' => Carbon::now('Europe/Kyiv')->toDateTimeString()];

        if (!$order->is_ready) {
            $data['is_ready'] = true;
            $data['prepared_at'] = Carbon::now('Europe/Kyiv')->toDateTimeString();
        }
        $order->update($data);
        wsMessage('order_updated');

        return to_route('orders.index');
    }

    public function setDelivered($id)
    {
        $order = Order::findOrFail($id);
        $this->deleteMessage($order->message_id);
        $order->update([ 'status' => OrderStatus::DELIVERED, 'delivered_at' => Carbon::now('Europe/Kyiv')->toDateTimeString() ]);

        wsMessage('order_updated');

        return to_route('orders.index');
    }

    public function ready($id, Messages $messages)
    {
        $order = Order::findOrFail($id);

        $message = preg_replace("/([01]?[0-9]|2[0-3])\:+[0-5][0-9]/", config('constants.orders.ready'), $order->message);
        $this->deleteMessage($order->message_id);
        $response = $this->sendMessage($message);
        $text = $order->courier->name ?? $order->status->text();
        $messages->updateKeyboard($id, $response->telegraphMessageId(), $text);

        $order->update(['ready_at' => Carbon::now('Europe/Kyiv')->format('H:i'), 'message' => $message, 'message_id' => $response->telegraphMessageId(), 'ready' => true]);
        wsMessage('order_updated');

        return to_route('orders.index');
    }

    public function plusTime($id)
    {
        $this->updateTime($id, 'addMinutes');

        return to_route('orders.index');
    }

    public function minusTime($id)
    {
        $this->updateTime($id, 'subMinutes');

        return to_route('orders.index');
    }

    public function courierPlusTime($id)
    {
        $this->courierUpdateTime($id, 'addMinutes');

        return to_route('orders.index');

    }

    public function courierMinusTime($id)
    {
        $this->courierUpdateTime($id, 'subMinutes');

        return to_route('orders.index');
    }

    public function cancel($id)
    {
        $order = Order::findOrFail($id);
        $this->deleteMessage($order->message_id);
        $order->update([ 'status' => OrderStatus::CANCELLED ]);

        wsMessage('order_updated');

        return to_route('orders.index')->with('message', 'order.cancelled');
    }

    protected function courierUpdateTime($id, $method, $count = 5)
    {
        $order = Order::findOrFail($id);
        if (Gate::allows('change-order-status', $order)) {
            $time = Carbon::parse($order->approximate_courier_arrived_at)->$method($count);
            $order->update(['approximate_courier_arrived_at' => $time]);
            wsMessage('order_updated');
        }

        return to_route('orders.index');
    }

    protected function updateTime($id, $method, $count = 5)
    {
        $order = Order::findOrFail($id);
        $time = Carbon::parse($order->prepared_at)->$method($count);

        $message = preg_replace("/([01]?[0-9]|2[0-3])\:+[0-5][0-9]/", $time->format('H:i'), $order->message);
        if(!str_contains($message, 'Оновлення!')){
            $message  = 'Оновлення! ' . $message;
        }
        $this->deleteMessage($order->message_id);
        $response = $this->sendMessage($message);
        $text = $order->courier->name ?? $order->status->text();
        $this->updateKeyboard($id, $response->telegraphMessageId(), $text);

        $order->update([ 'prepared_at' =>  $time, 'message' => $message, 'message_id' => $response->telegraphMessageId()]);
        wsMessage('order_updated');

        return to_route('orders.index');
    }

    protected function sendMessage($message)
    {
        $response = \Telegraph::html($message)->send();

        return $response;
    }

    protected function updateKeyboard($orderId, $messageId, $text)
    {
        $url = env('APP_URL') . '/orders/' . $orderId . '/take';

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
}
