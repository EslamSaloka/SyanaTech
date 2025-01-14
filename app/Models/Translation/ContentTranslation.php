<?php

namespace App\Models\Translation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentTranslation extends Model
{
    use HasFactory;

    protected $table = 'content_translations';
    public $timestamps = false;
    protected $fillable = [
        'title',
        'description'
    ];
}
