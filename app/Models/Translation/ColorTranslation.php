<?php

namespace App\Models\Translation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorTranslation extends Model
{
    use HasFactory;

    protected $table = 'color_translations';
    public $timestamps = false;
    protected $fillable = [
        'name',
    ];
}
