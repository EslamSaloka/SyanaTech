<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = "notifications";

    protected $fillable = [
        'user_id',
        'order_id',
        "notification_type", // system || admin
        "message",
        "seen",
    ];

    protected $casts = [
        'message' => 'array',
    ];

    public function user() {
        return $this->hasOne(\App\Models\User::class,'id','user_id');
    }

    public function order() {
        return $this->hasOne(\App\Models\Order::class,'id','order_id');
    }

    public function getGetMessageAttribute() {
        return (is_null($this->message)) ? "" : ( (!isset($this->message[\App::getLocale()])) ? "" : $this->message[\App::getLocale()] );
    }
}
