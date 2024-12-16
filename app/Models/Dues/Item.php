<?php

namespace App\Models\Dues;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = "dues_items";

    protected $fillable = [
        "dues_id",
        "order_id",
        "order_total",
        "order_dues",
    ];

    public function order() {
        return $this->hasOne(\App\Models\Order::class,'id','order_id');
    }

    public function dues() {
        return $this->hasOne(\App\Models\Dues::class,'id','dues_id');
    }
}
