<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = "orders";

    protected $fillable = [
        "customer_id",
        "car_id",
        "category_id",
        "provider_id",
        "car_country_factory_id",
        // ===== //
        "customer_name",
        // ADDRESS //
        "address_name",
        "location_name",
        "lat",
        "lng",
        "region_id",
        "city_id",
        // ADDRESS //
        "order_place",   // //in-location || in-center
        // ============ //
        "description",
        // ============ //
        "order_status", // new || in process || wait for pay || done || close
        "close_by",
        "close_by_id",
        "close_message",
        "cancel_at",
        // Price //
        "sub_total",
        "vat",
        "commission_price",
        "total",
        "dues",
        "process_at",
        "completed_at",
        "rate",
        // More Information //
        "car_information",
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'car_information' => 'array',
    ];

    public function region() {
        return $this->hasOne(\App\Models\Area::class,'id','region_id');
    }

    public function city() {
        return $this->hasOne(\App\Models\Area::class,'id','city_id');
    }

    public function customer() {
        return $this->hasOne(\App\Models\User::class,'id','customer_id');
    }

    public function provider() {
        return $this->hasOne(\App\Models\User::class,'id','provider_id');
    }

    public function car() {
        return $this->hasOne(\App\Models\Car::class,'id','car_id');
    }

    public function category() {
        return $this->hasOne(\App\Models\Category::class,'id','category_id');
    }

    public function answers() {
        return $this->hasMany(\App\Models\Order\Answer::class,'order_id','id');
    }

    public function images() {
        return $this->hasMany(\App\Models\Order\Image::class,'order_id','id');
    }

    public function items() {
        return $this->hasMany(\App\Models\Order\Item::class,'order_id','id');
    }

    public function carCountryFactory() {
        return $this->hasOne(\App\Models\CarCountryFactory::class,'id','car_country_factory_id');
    }

    public function refusals() {
        return $this->hasOne(\App\Models\Refusal::class,'id','close_message');
    }
}
