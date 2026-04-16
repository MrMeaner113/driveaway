<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InsuranceRate extends Model
{
    protected $fillable = [
        'vehicle_category_id',
        'daily_rate',
        'requires_transport_plates',
    ];

    protected function casts(): array
    {
        return [
            'requires_transport_plates' => 'boolean',
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
