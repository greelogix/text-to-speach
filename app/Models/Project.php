<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'project_name'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function voices(): HasMany
    {
        return $this->hasMany(Voice::class);
    }

    
}
