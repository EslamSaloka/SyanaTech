<?php

namespace App\Models\Translation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefusalTranslation extends Model
{
    use HasFactory;

    protected $table = 'refusal_translations';
    public $timestamps = false;
    protected $fillable = [
        'name',
    ];
}
