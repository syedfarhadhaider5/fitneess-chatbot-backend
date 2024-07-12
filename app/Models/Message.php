<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'question', 'answer', 'time', 'date', 'flag'
    ];
}
