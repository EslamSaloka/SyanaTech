<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Intro extends Model
{
    use HasFactory, Translatable;

    protected $translationForeignKey = "intro_id";
    public $translatedAttributes = ['description'];
    protected $table = "intros";
    protected $fillable = ['image'];
    public $translationModel = 'App\Models\Translation\IntroTranslation';

}
