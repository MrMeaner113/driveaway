<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class TripLog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ulid',
        'work_order_id',
        'driver_id',
        'log_date',
        'start_city',
        'end_city',
        'start_odometer',
        'end_odometer',
        'km_driven',
        'hotel_name',
        'hotel_cost_cents',
        'fuel_added_litres',
        'fuel_cost_cents',
        'meal_cost_cents',
        'notes',
        'client_update_sent',
        'client_update_sent_at',
    ];

    protected function casts(): array
    {
        return [
            'log_date'               => 'date',
            'client_update_sent'     => 'boolean',
            'client_update_sent_at'  => 'datetime',
            'fuel_added_litres'      => 'decimal:2',
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
}
