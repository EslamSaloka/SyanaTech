<?php

namespace App\Models\Translation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankTranslation extends Model
{
    use HasFactory;

    protected $table = 'bank_translations';
    public $timestamps = false;
    protected $fillable = [
        'bank_name',
        "account_name"
    ];  
}
