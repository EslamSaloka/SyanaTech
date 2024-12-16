<?php

namespace App\Models\Translation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnowUsTranslation extends Model
{
    use HasFactory;

    protected $table = 'know_us_translations';
    public $timestamps = false;
    protected $fillable = [
        'name',
    ];
}
