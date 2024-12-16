<?php

namespace App\Models\Translation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingTranslation extends Model
{
    use HasFactory;

    protected $table = 'setting_translations';
    public $timestamps = false;
    protected $fillable = [
        'value',
    ];
}
