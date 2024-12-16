<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Color extends Model
{
    use HasFactory, Translatable;

    protected $with =[
        'translations'
    ];
    protected $translationForeignKey = "color_id";
    public $translatedAttributes = ['name'];
    protected $table = "colors";
    protected $fillable = ['active'];
    public $translationModel = 'App\Models\Translation\ColorTranslation';
}
