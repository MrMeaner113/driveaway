<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $ulid
 * @property int $work_order_id
 * @property int $driver_id
 * @property int $travel_mode_id
 * @property string $travel_direction
 * @property string $departure_city
 * @property string $arrival_city
 * @property \Carbon\CarbonImmutable|null $departure_at
 * @property \Carbon\CarbonImmutable|null $arrival_at
 * @property int $cost_cents
 * @property string|null $booking_reference
 * @property string|null $notes
 * @property string $status
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read \App\Models\Driver|null $driver
 * @property-read \App\Models\TravelMode $travelMode
 * @property-read \App\Models\WorkOrder|null $workOrder
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverTravel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverTravel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverTravel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverTravel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverTravel whereArrivalAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverTravel whereArrivalCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverTravel whereBookingReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverTravel whereCostCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverTravel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverTravel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverTravel whereDepartureAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverTravel whereDepartureCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverTravel whereDriverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverTravel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverTravel whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverTravel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverTravel whereTravelDirection($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverTravel whereTravelModeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverTravel whereUlid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverTravel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverTravel whereWorkOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverTravel withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverTravel withoutTrashed()
 * @mixin \Eloquent
 */
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
