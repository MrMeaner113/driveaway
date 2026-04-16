<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $vehicle_category_id
 * @property int $daily_rate
 * @property \Carbon\CarbonImmutable $effective_date
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read string $daily_rate_formatted
 * @property-read \App\Models\VehicleCategory $vehicleCategory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransportPlateRate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransportPlateRate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransportPlateRate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransportPlateRate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransportPlateRate whereDailyRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransportPlateRate whereEffectiveDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransportPlateRate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransportPlateRate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransportPlateRate whereVehicleCategoryId($value)
 * @mixin \Eloquent
 */
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
