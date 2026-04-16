<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransportPlateRate extends Model
{
    protected $fillable = [
        'vehicle_category_id',
        'daily_rate',
        'effective_date',
    ];

    protected function casts(): array
    {
        return [
            'effective_date' => 'date',
        ];
    }

    public function vehicleCategory(): BelongsTo
    {
        return $this->belongsTo(VehicleCategory::class);
    }

    public function getDailyRateFormattedAttribute(): string
    {
        return '$' . number_format($this->daily_rate / 100, 2);
    }
}
