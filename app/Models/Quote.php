<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'quote_number',
        'contact_id',
        'organization_id',
        'quote_status_id',
        'origin_city_id',
        'origin_province_id',
        'destination_city_id',
        'destination_province_id',
        'rate_type_id',
        'distance_unit_id',
        'estimated_distance',
        'rate_per_unit',
        'estimated_fuel',
        'estimated_accommodations',
        'estimated_add_ons',
        'subtotal',
        'tax_amount',
        'total',
        'notes',
        'expires_at',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'date',
        ];
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(QuoteStatus::class, 'quote_status_id');
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

    public function addOnServices(): BelongsToMany
    {
        return $this->belongsToMany(AddOnService::class, 'quote_add_on_services')
            ->withPivot('amount')
            ->withTimestamps();
    }

    public function workOrder(): HasOne
    {
        return $this->hasOne(WorkOrder::class);
    }
}
