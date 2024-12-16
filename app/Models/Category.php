<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Category extends Model
{
    use HasFactory, Translatable;

    protected $with =[
        'translations'
    ];
    protected $translationForeignKey = "category_id";
    public $translatedAttributes = ['name'];
    protected $table = "categories";
    protected $fillable = ['image','active'];
    public $translationModel = 'App\Models\Translation\CategoryTranslation';

    public function showStatus() {
        if($this->active == 0) {
            return '<span class="make_pad badge bg-danger">'.__("Inactive").'</span>';
        } else {
            return '<span class="make_pad badge bg-success">'.__("Active").'</span>';
        }
    }
}
