<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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