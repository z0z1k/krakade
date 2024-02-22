<?php

namespace App\Http\Controllers\Courier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Gate;

use App\Actions\Stats\ChangeFormatTimeForView;

class Stats extends Controller
{
    public function show($id, ChangeFormatTimeForView $changeFormatTimeForView)
    {
        $user = User::findOrFail($id);
        $isCourier = Gate::allows('courier');

        $orders = $changeFormatTimeForView(Order::where('courier_id', $id)->with('place')->get());
        
        return view('courier.show', compact('user', 'isCourier', 'orders'));
    }
}
