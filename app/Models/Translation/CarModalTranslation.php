<?php

namespace App\Models\Translation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModalTranslation extends Model
{
    use HasFactory;

    protected $table = 'car_modal_translations';
    public $timestamps = false;
    protected $fillable = [
        'name',
    ];
}
