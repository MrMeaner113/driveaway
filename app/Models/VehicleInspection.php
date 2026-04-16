<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $ulid
 * @property int $work_order_id
 * @property int|null $vehicle_id
 * @property string $inspection_type
 * @property int $inspector_id
 * @property \Carbon\CarbonImmutable $inspected_at
 * @property int|null $odometer
 * @property string $fuel_level
 * @property string $overall_condition
 * @property string|null $notes
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read \App\Models\User|null $inspector
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VehicleInspectionItem> $items
 * @property-read int|null $items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Signature> $signatures
 * @property-read int|null $signatures_count
 * @property-read \App\Models\Vehicle|null $vehicle
 * @property-read \App\Models\WorkOrder|null $workOrder
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspection onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspection query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspection whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspection whereFuelLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspection whereInspectedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspection whereInspectionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspection whereInspectorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspection whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspection whereOdometer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspection whereOverallCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspection whereUlid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspection whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspection whereVehicleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspection whereWorkOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspection withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspection withoutTrashed()
 * @mixin \Eloquent
 */
class VehicleInspection extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ulid',
        'work_order_id',
        'vehicle_id',
        'inspection_type',
        'inspector_id',
        'inspected_at',
        'odometer',
        'fuel_level',
        'overall_condition',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'inspected_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->ulid)) {
                $model->ulid = (string) Str::ulid();
            }
        });
    }

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(VehicleInspectionItem::class);
    }

    public function signatures(): MorphMany
    {
        return $this->morphMany(Signature::class, 'signable');
    }
}
