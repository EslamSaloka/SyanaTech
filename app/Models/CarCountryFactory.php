<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class CarCountryFactory extends Model
{
    use HasFactory, Translatable;

    protected $with =[
        'translations'
    ];
    protected $translationForeignKey = "car_id";
    public $translatedAttributes = ['name'];
    protected $table = "car_country_factories";
    protected $fillable = ['active'];
    public $translationModel = 'App\Models\Translation\CarCountryFactoryTranslation';
}
