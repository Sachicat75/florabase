<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class PlantPhoto extends Model
{
    protected $fillable = [
        'user_id',
        'plant_id',
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

    public function plant(): BelongsTo
    {
        return $this->belongsTo(Plant::class);
    }

    public function getImageUrlAttribute(): string
    {
        return $this->path ? Storage::url($this->path) : '/images/placeholder.png';
    }
}
