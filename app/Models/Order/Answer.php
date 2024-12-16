<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $table = "order_providers_answer";

    protected $fillable = [
        "order_id",
        "provider_id",
        "answer",
        "accept",
    ];

    public function provider() {
        return $this->hasOne(\App\Models\User::class,'id','provider_id');
    }

    public function order() {
        return $this->hasOne(\App\Models\Order::class,'id','order_id');
    }
}
