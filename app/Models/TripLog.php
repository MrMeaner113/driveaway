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
 * @property \Carbon\CarbonImmutable $log_date
 * @property string $start_city
 * @property string $end_city
 * @property int|null $start_odometer
 * @property int|null $end_odometer
 * @property int $km_driven
 * @property string|null $hotel_name
 * @property int $hotel_cost_cents
 * @property numeric|null $fuel_added_litres
 * @property int $fuel_cost_cents
 * @property int $meal_cost_cents
 * @property string|null $notes
 * @property bool $client_update_sent
 * @property \Carbon\CarbonImmutable|null $client_update_sent_at
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read \App\Models\Driver|null $driver
 * @property-read \App\Models\WorkOrder|null $workOrder
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripLog onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripLog whereClientUpdateSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripLog whereClientUpdateSentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripLog whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripLog whereDriverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripLog whereEndCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripLog whereEndOdometer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripLog whereFuelAddedLitres($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripLog whereFuelCostCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripLog whereHotelCostCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripLog whereHotelName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripLog whereKmDriven($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripLog whereLogDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripLog whereMealCostCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripLog whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripLog whereStartCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripLog whereStartOdometer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripLog whereUlid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripLog whereWorkOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripLog withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripLog withoutTrashed()
 * @mixin \Eloquent
 */
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
