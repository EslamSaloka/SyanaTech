<?php

namespace App\Models\Translation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SliderTranslation extends Model
{
    use HasFactory;

    protected $table = 'slider_translations';
    public $timestamps = false;
    protected $fillable = [
        'name',
    ];
}
