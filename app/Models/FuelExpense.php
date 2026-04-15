<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

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
