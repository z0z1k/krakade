<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    use HasFactory;

    protected $fillable = ['be_ready', 'client_address', 'client_phone', 'place_id', 'message_id', 'comment', 'payment_type', 'status'];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    protected $casts = [
        'status' => \App\Enums\Order\Status::class,
    ];
}
