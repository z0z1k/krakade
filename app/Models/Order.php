<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Enums\Order\Status as OrderStatus;

use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['be_ready', 'client_address', 'client_phone', 'place_id', 'message_id', 'comment', 'payment_type', 'status', 'courier_id', 'get_at', 'delivered_at', 'message', 'ready', 'courier_arriving_time', 'ready_at'];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function courier()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function scopeActiveCourier($query)
    {
        return $query->whereNotIn('status', [ OrderStatus::DELIVERED, OrderStatus::CANCELLED ])->with('place', 'courier', 'place');
    }

    public function scopeActivePlace($query)
    {
        return $query->whereIn('place_id', Place::where('user_id', Auth::user()->id)->pluck('id'))
        ->whereNotIn('status', [ OrderStatus::DELIVERED, OrderStatus::CANCELLED ]);
    }

    public function scopeCancelled($query)
    {
        return $query->whereIn('place_id', Place::where('user_id', Auth::user()->id)->pluck('id'))->where('status', OrderStatus::CANCELLED);
    }

    public function scopeDeliveredAll($query)
    {
        return $query->where('status', OrderStatus::DELIVERED);
    }

    public function scopeDeliveredPlace($query)
    {
        return $query->whereIn('place_id', Place::where('user_id', Auth::user()->id)->pluck('id'))->where('status', OrderStatus::DELIVERED);
    }

    protected $casts = [
        'status' => \App\Enums\Order\Status::class,
    ];
}
