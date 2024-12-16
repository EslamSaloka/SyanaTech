<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $table = "cars";

    protected $fillable = [
        'color_id',
        'car_country_factory_id',
        'customer_id',
        "vin",
        "vds",
        "region",
        "country",
        "manufacturer",
        "modelYear",
        "data",
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];

    public function user() {
        return $this->hasOne(\App\Models\User::class,'id','customer_id');
    }

    public function color() {
        return $this->hasOne(\App\Models\Color::class,'id','color_id');
    }

    public function carCountryFactory() {
        return $this->hasOne(\App\Models\CarCountryFactory::class,'id','car_country_factory_id');
    }

    //

    public function vdsData() {
        return $this->hasOne(\App\Models\CarModal::class,'id','vds');
    }

    public function manufacturerData() {
        return $this->hasOne(\App\Models\CarModal::class,'id','manufacturer');
    }
}
