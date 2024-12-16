<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class CarModal extends Model
{
    use HasFactory, Translatable;

    protected $with =[
        'translations'
    ];
    protected $translationForeignKey = "car_modal_id";
    public $translatedAttributes = ['name'];
    protected $table = "car_modals";
    protected $fillable = ['parent_id'];
    public $translationModel = 'App\Models\Translation\CarModalTranslation';

    public function parent() {
        return $this->hssOne(self::class,'id','parent_id');
    }

    public function children() {
        return $this->hasMany(self::class,'parent_id','id');
    }
}
