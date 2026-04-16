<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $ulid
 * @property int $work_order_id
 * @property int|null $driver_id
 * @property int $vehicle_id
 * @property numeric $litres
 * @property int $cost_per_litre
 * @property int $total_cost
 * @property int|null $odometer_reading
 * @property \Carbon\CarbonImmutable $fuel_date
 * @property string|null $station_name
 * @property string|null $notes
 * @property int $recorded_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read mixed $cost_per_litre_formatted
 * @property-read \App\Models\Driver|null $driver
 * @property-read \App\Models\User|null $recordedBy
 * @property-read mixed $total_cost_formatted
 * @property-read \App\Models\Vehicle|null $vehicle
 * @property-read \App\Models\WorkOrder|null $workOrder
 * @method static Builder<static>|FuelExpense forDriver(int $driverId)
 * @method static Builder<static>|FuelExpense forVehicle(int $vehicleId)
 * @method static Builder<static>|FuelExpense forWorkOrder(int $workOrderId)
 * @method static Builder<static>|FuelExpense newModelQuery()
 * @method static Builder<static>|FuelExpense newQuery()
 * @method static Builder<static>|FuelExpense onlyTrashed()
 * @method static Builder<static>|FuelExpense query()
 * @method static Builder<static>|FuelExpense whereCostPerLitre($value)
 * @method static Builder<static>|FuelExpense whereCreatedAt($value)
 * @method static Builder<static>|FuelExpense whereDeletedAt($value)
 * @method static Builder<static>|FuelExpense whereDriverId($value)
 * @method static Builder<static>|FuelExpense whereFuelDate($value)
 * @method static Builder<static>|FuelExpense whereId($value)
 * @method static Builder<static>|FuelExpense whereLitres($value)
 * @method static Builder<static>|FuelExpense whereNotes($value)
 * @method static Builder<static>|FuelExpense whereOdometerReading($value)
 * @method static Builder<static>|FuelExpense whereRecordedBy($value)
 * @method static Builder<static>|FuelExpense whereStationName($value)
 * @method static Builder<static>|FuelExpense whereTotalCost($value)
 * @method static Builder<static>|FuelExpense whereUlid($value)
 * @method static Builder<static>|FuelExpense whereUpdatedAt($value)
 * @method static Builder<static>|FuelExpense whereVehicleId($value)
 * @method static Builder<static>|FuelExpense whereWorkOrderId($value)
 * @method static Builder<static>|FuelExpense withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|FuelExpense withoutTrashed()
 * @mixin \Eloquent
 */
class FuelExpense extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'work_order_id',
        'driver_id',
        'vehicle_id',
        'litres',
        'cost_per_litre',
        'total_cost',
        'odometer_reading',
        'fuel_date',
        'station_name',
        'notes',
        'recorded_by',
    ];

    protected function casts(): array
    {
        return [
            'litres'    => 'decimal:2',
            'fuel_date' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (FuelExpense $fuel) {
            if (auth()->check()) {
                $fuel->recorded_by = auth()->id();
            }
            $fuel->total_cost = (int) round((float) $fuel->litres * $fuel->cost_per_litre);
        });

        static::updating(function (FuelExpense $fuel) {
            $fuel->total_cost = (int) round((float) $fuel->litres * $fuel->cost_per_litre);
        });
    }

    // ── Relationships ────────────────────────────────────────────────────────

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    // ── Accessors ────────────────────────────────────────────────────────────

    protected function totalCostFormatted(): Attribute
    {
        return Attribute::get(fn () => '$' . number_format($this->total_cost / 100, 2));
    }

    protected function costPerLitreFormatted(): Attribute
    {
        return Attribute::get(fn () => '$' . number_format($this->cost_per_litre / 100, 4));
    }

    // ── Scopes ───────────────────────────────────────────────────────────────

    public function scopeForWorkOrder(Builder $query, int $workOrderId): Builder
    {
        return $query->where('work_order_id', $workOrderId);
    }

    public function scopeForDriver(Builder $query, int $driverId): Builder
    {
        return $query->where('driver_id', $driverId);
    }

    public function scopeForVehicle(Builder $query, int $vehicleId): Builder
    {
        return $query->where('vehicle_id', $vehicleId);
    }
}
