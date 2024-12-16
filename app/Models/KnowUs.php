<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class KnowUs extends Model
{
    use HasFactory, Translatable;

    protected $with =[
        'translations'
    ];
    protected $translationForeignKey = "know_us_id";
    public $translatedAttributes = ['name'];
    protected $table = "know_us";
    protected $fillable = ['active'];
    public $translationModel = 'App\Models\Translation\KnowUsTranslation';
}
