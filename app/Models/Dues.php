<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dues extends Model
{
    use HasFactory;

    protected $table = "dues";

    protected $fillable = [
        'provider_id',
        'total',
        'invoiceId',
        'accept',
        'reject',
    ];

    public function provider() {
        return $this->hasOne(\App\Models\User::class,'id','provider_id');
    }

    public function items() {
        return $this->hasMany(\App\Models\Dues\Item::class,'dues_id','id');
    }
}
