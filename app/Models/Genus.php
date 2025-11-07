<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Genus extends Model
{
    protected $fillable = [
        'user_id',
        'subfamily_id',
        'name',
        'description',
        'image',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subfamily(): BelongsTo
    {
        return $this->belongsTo(Subfamily::class);
    }

    public function plants(): HasMany
    {
        return $this->hasMany(Plant::class);
    }
}
