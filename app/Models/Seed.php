<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seed extends Model
{
    protected $fillable = [
        'user_id',
        'vendor_id',
        'location_id',
        'name',
        'scientific_name',
        'quantity',
        'purchase_price',
        'purchased_at',
        'sow_by',
        'germination_media',
        'start_date',
        'date_germinated',
        'germination_temperature',
        'notes',
    ];

    protected $casts = [
        'purchased_at' => 'date',
        'sow_by' => 'date',
        'start_date' => 'date',
        'date_germinated' => 'date',
        'purchase_price' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
        return $this->hasMany(SeedPhoto::class);
    }
}
