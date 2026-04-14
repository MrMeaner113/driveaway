<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

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
