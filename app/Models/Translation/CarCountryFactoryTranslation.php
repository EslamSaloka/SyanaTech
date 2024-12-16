<?php

namespace App\Models\Translation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarCountryFactoryTranslation extends Model
{
    use HasFactory;

    protected $table = 'car_country_factory_translations';
    public $timestamps = false;
    protected $fillable = [
        'name',
    ];
}
