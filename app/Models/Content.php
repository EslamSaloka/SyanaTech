<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Content extends Model {

    use HasFactory, Translatable;

    protected $with =[
        'translations'
    ];
    protected $translationForeignKey = "content_id";
    public $translatedAttributes = ['title','description'];
    protected $table = "contents";
    protected $fillable = ['image'];
    public $translationModel = 'App\Models\Translation\ContentTranslation';
}

