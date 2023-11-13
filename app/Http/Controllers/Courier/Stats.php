<?php

namespace App\Http\Controllers\Courier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Gate;

class Stats extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $isCourier = Gate::allows('courier');
        $ordersCnt = Order::where('courier_id', $id)->count();
        return view('courier.show', compact('user', 'isCourier', 'ordersCnt'));
    }
}
