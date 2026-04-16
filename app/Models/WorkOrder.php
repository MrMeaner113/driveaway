<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $work_order_number
 * @property int|null $quote_id
 * @property int $work_order_status_id
 * @property int $origin_city_id
 * @property int $origin_province_id
 * @property int $destination_city_id
 * @property int $destination_province_id
 * @property \Carbon\CarbonImmutable $scheduled_pickup
 * @property \Carbon\CarbonImmutable|null $scheduled_delivery
 * @property \Carbon\CarbonImmutable|null $actual_pickup
 * @property \Carbon\CarbonImmutable|null $actual_delivery
 * @property int $rate_type_id
 * @property int $distance_unit_id
 * @property int $distance
 * @property int $rate_per_unit
 * @property string|null $notes
 * @property int $created_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contact> $contacts
 * @property-read int|null $contacts_count
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\City|null $destinationCity
 * @property-read \App\Models\Province|null $destinationProvince
 * @property-read \App\Models\DistanceUnit|null $distanceUnit
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document> $documents
 * @property-read int|null $documents_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DriverTravel> $driverTravel
 * @property-read int|null $driver_travel_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Driver> $drivers
 * @property-read int|null $drivers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Expense> $expenses
 * @property-read int|null $expenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FuelExpense> $fuelExpenses
 * @property-read int|null $fuel_expenses_count
 * @property-read \App\Models\GpsTracking|null $gpsTracking
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Invoice> $invoices
 * @property-read int|null $invoices_count
 * @property-read \App\Models\City|null $originCity
 * @property-read \App\Models\Province|null $originProvince
 * @property-read \App\Models\Quote|null $quote
 * @property-read \App\Models\RateType|null $rateType
 * @property-read \App\Models\WorkOrderStatus|null $status
 * @property-read mixed $total_expenses_amount
 * @property-read mixed $total_expenses_formatted
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TripLog> $tripLogs
 * @property-read int|null $trip_logs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VehicleInspection> $vehicleInspections
 * @property-read int|null $vehicle_inspections_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vehicle> $vehicles
 * @property-read int|null $vehicles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereActualDelivery($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereActualPickup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereDestinationCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereDestinationProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereDistanceUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereOriginCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereOriginProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereQuoteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereRatePerUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereRateTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereScheduledDelivery($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereScheduledPickup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereWorkOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereWorkOrderStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder withoutTrashed()
 * @mixin \Eloquent
 */
class WorkOrder extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'work_order_number',
        'quote_id',
        'work_order_status_id',
        'origin_city_id',
        'origin_province_id',
        'destination_city_id',
        'destination_province_id',
        'scheduled_pickup',
        'scheduled_delivery',
        'actual_pickup',
        'actual_delivery',
        'rate_type_id',
        'distance_unit_id',
        'distance',
        'rate_per_unit',
        'notes',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_pickup'    => 'date',
            'scheduled_delivery'  => 'date',
            'actual_pickup'       => 'date',
            'actual_delivery'     => 'date',
        ];
    }

    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(WorkOrderStatus::class, 'work_order_status_id');
    }

    public function originCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'origin_city_id');
    }

    public function originProvince(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'origin_province_id');
    }

    public function destinationCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'destination_city_id');
    }

    public function destinationProvince(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'destination_province_id');
    }

    public function rateType(): BelongsTo
    {
        return $this->belongsTo(RateType::class);
    }

    public function distanceUnit(): BelongsTo
    {
        return $this->belongsTo(DistanceUnit::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function vehicles(): BelongsToMany
    {
        return $this->belongsToMany(Vehicle::class, 'work_order_vehicles')->withTimestamps();
    }

    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class, 'work_order_contacts')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function drivers(): BelongsToMany
    {
        return $this->belongsToMany(Driver::class, 'work_order_drivers')
            ->withPivot('vehicle_id')
            ->withTimestamps();
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function fuelExpenses(): HasMany
    {
        return $this->hasMany(FuelExpense::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function vehicleInspections(): HasMany
    {
        return $this->hasMany(VehicleInspection::class);
    }

    public function tripLogs(): HasMany
    {
        return $this->hasMany(TripLog::class);
    }

    public function driverTravel(): HasMany
    {
        return $this->hasMany(DriverTravel::class);
    }

    public function gpsTracking(): HasOne
    {
        return $this->hasOne(GpsTracking::class);
    }

    // ── Accessors ────────────────────────────────────────────────────────────

    protected function totalExpensesAmount(): Attribute
    {
        return Attribute::get(function () {
            $expenses  = $this->expenses()->sum('amount');
            $fuel      = $this->fuelExpenses()->sum('total_cost');
            return $expenses + $fuel;
        });
    }

    protected function totalExpensesFormatted(): Attribute
    {
        return Attribute::get(fn () => '$' . number_format($this->total_expenses_amount / 100, 2));
    }
}
