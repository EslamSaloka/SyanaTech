<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const TYPE_ADMIN    = "admin";
    const TYPE_CUSTOMER = "customer";
    const TYPE_PROVIDER = "provider";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'phone_verified_at',
        'otp',
        'password',
        'api_token',
        'devices_token',
        'user_type', // admin || customer || provider
        'avatar',
        'how_to_know_us',
        // =====================================  //
        // =========== Provider Data ===========  //
        // =====================================  //
        'provider_name',
        'commercial_registration_number',
        'tax_number',
        'region',
        'city',
        'lat',
        'lng',
        'terms',
        'rates',
        'vat',
        'commission_price',
        // =====================================  //
        'otp',
        // =====================================  //
        'admin_approved',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    // =====================================  //
    // =========== Customer Data ===========  //
    // =====================================  //

    public function cars() {
        return $this->hasMany(\App\Models\Car::class,'customer_id','id');
    }

    public function customerOrders() {
        return $this->hasMany(\App\Models\Order::class,'customer_id','id');
    }

    // =====================================  //
    // =========== Provider Data ===========  //
    // =====================================  //

    // categories

    public function categories() {
        return $this->belongsToMany(\App\Models\Category::class, 'provider_categories_pivot', 'provider_id','category_id');
    }

    public function carCountryFactories() {
        return $this->belongsToMany(\App\Models\CarCountryFactory::class, 'provider_car_factories_pivot', 'provider_id','car_id');
    }

    public function rates() {
        return $this->hasMany(\App\Models\Rate::class,'provider_id','id');
    }

    public function providerOrders() {
        return $this->hasMany(\App\Models\Order::class,'provider_id','id');
    }

    public function getRegion() {
        return $this->hasOne(\App\Models\Area::class,'id','region');
    }

    public function getCity() {
        return $this->hasOne(\App\Models\Area::class,'id','city');
    }

    // =======

    public function getNotifications() {
        return $this->hasMany(\App\Models\Notification::class,'user_id','id');
    }

    public function KnowUs() {
        return $this->hasOne(\App\Models\KnowUs::class,'id','how_to_know_us');
    }

    public function showStatus() {
        if($this->admin_approved == 0) {
            return '<span class="make_pad badge bg-danger">'.__("NO").'</span>';
        } else {
            return '<span class="make_pad badge bg-success">'.__("Yes").'</span>';
        }
    }

    public function providerIndex() {
        $data = [
            "id"                => $this->id,
            "name"              => $this->provider_name,
            "vat"               => $this->vat,
            "commission_price"  => $this->commission_price,
        ];
        return json_encode($data);
    }
}
