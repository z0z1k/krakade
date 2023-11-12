<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Enums\Order\Status as OrderStatus;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['be_ready', 'client_address', 'client_phone', 'place_id', 'message_id', 'comment', 'payment_type', 'status', 'courier_id', 'get_at', 'delivered_at', 'message'];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function courier()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActiveCourier($query)
    {
        return $query->whereNotIn('status', [ OrderStatus::DELIVERED, OrderStatus::CANCELLED ]);
    }

    public function scopeActivePlace($query)
    {
        return $query->whereIn('place_id', Place::where('user_id', Auth::user()->id)->pluck('id'))
        ->whereNotIn('status', [ OrderStatus::DELIVERED, OrderStatus::CANCELLED ]);
    }

    protected $casts = [
        'status' => \App\Enums\Order\Status::class,
    ];
}
