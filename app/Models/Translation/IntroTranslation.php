<?php

namespace App\Models\Translation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntroTranslation extends Model
{
    use HasFactory;

    protected $table = 'intro_translations';
    public $timestamps = false;
    protected $fillable = [
        'description',
    ];
}
