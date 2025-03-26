<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ApiKey extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'key', 'quota', 'is_active'];

    /**
     * Generate a new unique API key
     */
    public static function generateKey()
    {
        return Str::random(32);
    }

    /**
     * Relationship: Each API key belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

