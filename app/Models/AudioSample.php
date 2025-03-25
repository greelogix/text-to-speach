<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AudioSample extends Model
{
    use HasFactory;

    protected $fillable = ['audio_base64'];
}
