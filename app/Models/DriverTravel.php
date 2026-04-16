<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DriverTravel extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ulid',
        'work_order_id',
        'driver_id',
        'travel_mode_id',
        'travel_direction',
        'departure_city',
        'arrival_city',
        'departure_at',
        'arrival_at',
        'cost_cents',
        'booking_reference',
        'notes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'departure_at' => 'datetime',
            'arrival_at'   => 'datetime',
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

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function travelMode(): BelongsTo
    {
        return $this->belongsTo(TravelMode::class);
    }
}
