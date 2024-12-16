<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = "contacts";

    protected $fillable = [
        'user_id',
        'message_type',
        'message',
        'seen',
    ];

    public function showStatus() {
        if($this->seen == 0) {
            return '<span class="make_pad badge bg-danger">'.__("Unseen").'</span>';
        } else {
            return '<span class="make_pad badge bg-success">'.__("Seen").'</span>';
        }
    }

    public function user() {
        return $this->hasOne(\App\Models\User::class,'id','user_id');
    }
}
