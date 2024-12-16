<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = "order_images";

    protected $fillable = [
        "order_id",
        "image",
    ];

    public function order() {
        return $this->hasOne(\App\Models\Order::class,'id','order_id');
    }
}
