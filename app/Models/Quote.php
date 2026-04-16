<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        'trip_plan_id',
        'vehicle_category_id',
        'discount_type',
        'discount_value',
        'discount_reason_id',
        'discount_amount_cents',
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

    public function tripPlan(): BelongsTo
    {
        return $this->belongsTo(TripPlan::class);
    }

    public function vehicleCategory(): BelongsTo
    {
        return $this->belongsTo(VehicleCategory::class);
    }

    public function discountReason(): BelongsTo
    {
        return $this->belongsTo(DiscountReason::class);
    }

    // ── Accessors ────────────────────────────────────────────────────────────

    public function getDiscountFormattedAttribute(): string
    {
        if (! $this->discount_type || ! $this->discount_value) {
            return '$0.00';
        }

        if ($this->discount_type === 'percentage') {
            $pct = $this->discount_value / 100;
            return number_format($pct, 2) . '%';
        }

        return '$' . number_format($this->discount_value / 100, 2);
    }

    // ── Methods ──────────────────────────────────────────────────────────────

    /**
     * Compute discount_amount_cents from discount_type + discount_value
     * applied against the total (subtotal + tax).
     */
    public function applyDiscount(): void
    {
        if (! $this->discount_type || ! $this->discount_value) {
            $this->discount_amount_cents = 0;
            return;
        }

        if ($this->discount_type === 'flat') {
            $this->discount_amount_cents = $this->discount_value;
        } else {
            // percentage: discount_value is basis points (e.g. 1000 = 10%)
            $this->discount_amount_cents = (int) round($this->total * ($this->discount_value / 10000));
        }
    }
}
