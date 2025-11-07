<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Propagation extends Model
{
    protected $fillable = [
        'user_id',
        'plant_id',
        'location_id',
        'method',
        'status',
        'start_date',
        'rooted_date',
        'germination_temperature',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'rooted_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plant(): BelongsTo
    {
        return $this->belongsTo(Plant::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
