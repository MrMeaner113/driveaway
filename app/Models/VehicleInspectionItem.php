<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
