<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Enums\Order\Status as OrderStatus;

use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'place_id',
        'courier_id',
        'prepared_at',
        'prepared_at',
        'taken_at',
        'delivered_at',
        'approximate_ready_at',
        'approximate_courier_arrived_at',
        'is_ready',
        'payment',
        'problem',
        'city_id',
        'client_phone',
        'message_id',
        'comment',
        'status',
        'message',
        'address',
        'address_info',
        'location',
        'price'
    ];

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
        return $query->whereIn('place_id', Place::where('user_id', Auth::user()->id)->pluck('id'))->with('place')->where('status', OrderStatus::CANCELLED)->orderByDesc('created_at');
    }

    public function scopeDeliveredAll($query)
    {
        return $query->where('status', OrderStatus::DELIVERED)->with('place')->orderByDesc('created_at');
    }

    public function scopeDeliveredPlace($query)
    {
        return $query->whereIn('place_id', Place::where('user_id', Auth::user()->id)->pluck('id'))->where('status', OrderStatus::DELIVERED)->with('place')->orderByDesc('created_at');
    }

    protected $casts = [
        'status' => \App\Enums\Order\Status::class,
    ];
}
