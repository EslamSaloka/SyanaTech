<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Bank extends Model
{
    use HasFactory, Translatable;

    protected $with =[
        'translations'
    ];
    protected $translationForeignKey = "bank_id";
    public $translatedAttributes = ['bank_name',"account_name"];
    protected $table = "banks";
    protected $fillable = ['account_number',"image","iban"];
    public $translationModel = 'App\Models\Translation\BankTranslation';
}
