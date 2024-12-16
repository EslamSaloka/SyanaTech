<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Slider extends Model
{
    use HasFactory, Translatable;

    protected $translationForeignKey = "slider_id";
    public $translatedAttributes = ['name'];
    protected $table = "sliders";
    protected $fillable = ['image','active','provider_id'];
    public $translationModel = 'App\Models\Translation\SliderTranslation';

    public function provider() {
        return $this->hasOne(User::class,"id","provider_id");
    }

    public function showStatus() {
        if($this->active == 0) {
            return '<span class="make_pad badge bg-danger">'.__("Inactive").'</span>';
        } else {
            return '<span class="make_pad badge bg-success">'.__("Active").'</span>';
        }
    }
}
