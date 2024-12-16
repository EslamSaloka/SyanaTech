<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    protected $table = "provider_rates";

    protected $fillable = [
        'customer_id',
        'provider_id',
        'order_id',
        "rate",
        "message",
    ];

    public function customer() {
        return $this->hasOne(\App\Models\User::class,'id','customer_id');
    }

    public function provider() {
        return $this->hasOne(\App\Models\User::class,'id','provider_id');
    }

    public function order() {
        return $this->hasOne(\App\Models\Order::class,'id','order_id');
    }
}
