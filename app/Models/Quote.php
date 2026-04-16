<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $quote_number
 * @property int $contact_id
 * @property int|null $organization_id
 * @property int $quote_status_id
 * @property int $origin_city_id
 * @property int $origin_province_id
 * @property int $destination_city_id
 * @property int $destination_province_id
 * @property int $rate_type_id
 * @property int $distance_unit_id
 * @property int $estimated_distance
 * @property int $rate_per_unit
 * @property int $estimated_fuel
 * @property int $estimated_accommodations
 * @property int $estimated_add_ons
 * @property int $subtotal
 * @property int $tax_amount
 * @property int $total
 * @property string|null $notes
 * @property \Carbon\CarbonImmutable|null $expires_at
 * @property int $created_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property int|null $trip_plan_id
 * @property int|null $vehicle_category_id
 * @property string|null $discount_type
 * @property int|null $discount_value
 * @property int|null $discount_reason_id
 * @property int $discount_amount_cents
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AddOnService> $addOnServices
 * @property-read int|null $add_on_services_count
 * @property-read \App\Models\Contact|null $contact
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\City|null $destinationCity
 * @property-read \App\Models\Province|null $destinationProvince
 * @property-read \App\Models\DiscountReason|null $discountReason
 * @property-read \App\Models\DistanceUnit|null $distanceUnit
 * @property-read string $discount_formatted
 * @property-read \App\Models\Organization|null $organization
 * @property-read \App\Models\City|null $originCity
 * @property-read \App\Models\Province|null $originProvince
 * @property-read \App\Models\RateType|null $rateType
 * @property-read \App\Models\QuoteStatus|null $status
 * @property-read \App\Models\TripPlan|null $tripPlan
 * @property-read \App\Models\VehicleCategory|null $vehicleCategory
 * @property-read \App\Models\WorkOrder|null $workOrder
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereDestinationCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereDestinationProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereDiscountAmountCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereDiscountReasonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereDiscountValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereDistanceUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereEstimatedAccommodations($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereEstimatedAddOns($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereEstimatedDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereEstimatedFuel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereOriginCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereOriginProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereQuoteNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereQuoteStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereRatePerUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereRateTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereTripPlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereVehicleCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote withoutTrashed()
 * @mixin \Eloquent
 */
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
