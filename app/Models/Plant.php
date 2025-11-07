<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plant extends Model
{
    protected $fillable = [
        'user_id',
        'genus_id',
        'vendor_id',
        'location_id',
        'common_name',
        'species',
        'purchase_price',
        'acquired_at',
        'light_level',
        'water_frequency',
        'last_watered_at',
        'notes',
    ];

    protected $casts = [
        'acquired_at' => 'date',
        'last_watered_at' => 'date',
        'purchase_price' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function genus(): BelongsTo
    {
        return $this->belongsTo(Genus::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(PlantPhoto::class);
    }

    public function propagations(): HasMany
    {
        return $this->hasMany(Propagation::class);
    }
}
