<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class TextToSpeechVoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'gender',
        'locale',
        'friendly_name',
    ];
}