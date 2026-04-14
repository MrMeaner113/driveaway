<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
