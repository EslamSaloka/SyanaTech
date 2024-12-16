<?php

namespace App\Models\Translation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaTranslation extends Model
{
    use HasFactory;

    protected $table = 'area_translations';
    public $timestamps = false;
    protected $fillable = [
        'name',
    ];
}
