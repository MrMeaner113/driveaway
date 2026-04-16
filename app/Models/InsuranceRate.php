<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $vehicle_category_id
 * @property int $daily_rate
 * @property bool $requires_transport_plates
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read string $daily_rate_formatted
 * @property-read \App\Models\VehicleCategory $vehicleCategory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InsuranceRate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InsuranceRate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InsuranceRate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InsuranceRate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InsuranceRate whereDailyRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InsuranceRate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InsuranceRate whereRequiresTransportPlates($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InsuranceRate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InsuranceRate whereVehicleCategoryId($value)
 * @mixin \Eloquent
 */
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
