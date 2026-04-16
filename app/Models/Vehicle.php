<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $vehicle_make_id
 * @property int $vehicle_model_id
 * @property int $year
 * @property string $color
 * @property string|null $vin
 * @property int $driveline_id
 * @property int $fuel_type_id
 * @property int $odometer
 * @property bool $is_active
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read \App\Models\Driveline|null $driveline
 * @property-read \App\Models\FuelType|null $fuelType
 * @property-read \App\Models\VehicleMake|null $make
 * @property-read \App\Models\VehicleModel|null $model
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereDrivelineId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereFuelTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereOdometer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereVehicleMakeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereVehicleModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereVin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle withoutTrashed()
 * @mixin \Eloquent
 */
class Vehicle extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'vehicle_make_id',
        'vehicle_model_id',
        'year',
        'color',
        'vin',
        'driveline_id',
        'fuel_type_id',
        'odometer',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'year'      => 'integer',
            'odometer'  => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function make(): BelongsTo
    {
        return $this->belongsTo(VehicleMake::class, 'vehicle_make_id');
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class, 'vehicle_model_id');
    }

    public function driveline(): BelongsTo
    {
        return $this->belongsTo(Driveline::class);
    }

    public function fuelType(): BelongsTo
    {
        return $this->belongsTo(FuelType::class);
    }
}
