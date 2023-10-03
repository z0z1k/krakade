<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [ 'name', 'address', 'phone', 'email', 'user_id' ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
