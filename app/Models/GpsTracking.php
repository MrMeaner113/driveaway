<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read \App\Models\WorkOrder|null $workOrder
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GpsTracking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GpsTracking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GpsTracking query()
 * @mixin \Eloquent
 */
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
