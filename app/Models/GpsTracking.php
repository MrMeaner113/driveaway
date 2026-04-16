<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GpsTracking extends Model
{
    protected $fillable = [
        'work_order_id',
        'followmee_device_id',
        'tracking_url',
        'activated_at',
        'deactivated_at',
    ];

    protected function casts(): array
    {
        return [
            'activated_at'   => 'datetime',
            'deactivated_at' => 'datetime',
        ];
    }

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }
}
