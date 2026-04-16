<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $vehicle_make_id
 * @property string $name
 * @property bool $is_active
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read \App\Models\VehicleMake|null $vehicleMake
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleModel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleModel whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleModel whereVehicleMakeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleModel withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleModel withoutTrashed()
 * @mixin \Eloquent
 */
class VehicleModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'vehicle_make_id',
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function vehicleMake()
    {
        return $this->belongsTo(VehicleMake::class);
    }
}