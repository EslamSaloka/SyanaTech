<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Area extends Model
{
    use HasFactory, Translatable;

    protected $with =[
        'translations'
    ];
    protected $translationForeignKey = "area_id";
    public $translatedAttributes = ['name'];
    protected $table = "areas";
    protected $fillable = ['parent'];
    public $translationModel = 'App\Models\Translation\AreaTranslation';
}
