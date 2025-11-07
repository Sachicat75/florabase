<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class SeedPhoto extends Model
{
    protected $fillable = [
        'user_id',
        'seed_id',
        'path',
        'caption',
        'order',
    ];

    protected $appends = [
        'image_url',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function seed(): BelongsTo
    {
        return $this->belongsTo(Seed::class);
    }

    public function getImageUrlAttribute(): string
    {
        return $this->path ? Storage::url($this->path) : '/images/placeholder.png';
    }
}
