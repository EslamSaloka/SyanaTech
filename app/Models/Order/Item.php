<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = "order_items";

    protected $fillable = [
        "order_id",
        "name",
        "price",
    ];

    public function order() {
        return $this->hasOne(\App\Models\Order::class,'id','order_id');
    }
}
