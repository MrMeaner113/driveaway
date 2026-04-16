<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $vehicle_inspection_id
 * @property string $location
 * @property string $damage_type
 * @property string $severity
 * @property string|null $photo_path
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\VehicleInspection|null $inspection
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspectionItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspectionItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspectionItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspectionItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspectionItem whereDamageType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspectionItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspectionItem whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspectionItem wherePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspectionItem whereSeverity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspectionItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleInspectionItem whereVehicleInspectionId($value)
 * @mixin \Eloquent
 */
class VehicleInspectionItem extends Model
{
    protected $fillable = [
        'vehicle_inspection_id',
        'location',
        'damage_type',
        'severity',
        'photo_path',
    ];

    public function inspection(): BelongsTo
    {
        return $this->belongsTo(VehicleInspection::class, 'vehicle_inspection_id');
    }
}
