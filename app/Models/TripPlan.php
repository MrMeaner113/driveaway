<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $ulid
 * @property int $quote_request_id
 * @property int $distance_km
 * @property int $detour_buffer_pct
 * @property int $adjusted_distance_km
 * @property int $speed_kmh
 * @property int $drive_hours_per_day
 * @property int $km_per_day
 * @property int $drive_days
 * @property int $delay_days
 * @property int $delay_day_per_km
 * @property int $total_days
 * @property int $hotel_nights
 * @property numeric $fuel_economy_per_100km
 * @property int $avg_fuel_price_cents
 * @property int $fuel_cost_cents
 * @property int $driver_rate_cents_per_km
 * @property int $driver_cost_cents
 * @property int $hotel_rate_cents
 * @property int $hotel_cost_cents
 * @property int $meal_cost_cents
 * @property int $meals_per_day
 * @property int $meal_cost_total_cents
 * @property int|null $insurance_rate_id
 * @property int $insurance_cost_cents
 * @property int|null $transport_plate_rate_id
 * @property int $transport_plate_cost_cents
 * @property int $tolls_and_ferry_cents
 * @property int $subtotal_cents
 * @property numeric $tax_rate
 * @property int $tax_amount_cents
 * @property int $total_cents
 * @property string|null $notes
 * @property int $created_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property int|null $insurance_cost_override_cents
 * @property int|null $transport_plate_cost_override_cents
 * @property int|null $fuel_type_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AddOnService> $addOnServices
 * @property-read int|null $add_on_services_count
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\FuelType|null $fuelType
 * @property-read \App\Models\InsuranceRate|null $insuranceRate
 * @property-read \App\Models\QuoteRequest|null $quoteRequest
 * @property-read \App\Models\TransportPlateRate|null $transportPlateRate
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan forQuoteRequest(int $quoteRequestId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereAdjustedDistanceKm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereAvgFuelPriceCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereDelayDayPerKm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereDelayDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereDetourBufferPct($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereDistanceKm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereDriveDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereDriveHoursPerDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereDriverCostCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereDriverRateCentsPerKm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereFuelCostCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereFuelEconomyPer100km($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereFuelTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereHotelCostCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereHotelNights($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereHotelRateCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereInsuranceCostCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereInsuranceCostOverrideCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereInsuranceRateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereKmPerDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereMealCostCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereMealCostTotalCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereMealsPerDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereQuoteRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereSpeedKmh($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereSubtotalCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereTaxAmountCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereTaxRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereTollsAndFerryCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereTotalCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereTotalDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereTransportPlateCostCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereTransportPlateCostOverrideCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereTransportPlateRateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereUlid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TripPlan withoutTrashed()
 * @mixin \Eloquent
 */
class TripPlan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ulid',
        'quote_request_id',
        'distance_km',
        'detour_buffer_pct',
        'adjusted_distance_km',
        'speed_kmh',
        'drive_hours_per_day',
        'km_per_day',
        'drive_days',
        'delay_days',
        'delay_day_per_km',
        'total_days',
        'hotel_nights',
        'fuel_economy_per_100km',
        'avg_fuel_price_cents',
        'fuel_cost_cents',
        'driver_rate_cents_per_km',
        'driver_cost_cents',
        'hotel_rate_cents',
        'hotel_cost_cents',
        'meal_cost_cents',
        'meals_per_day',
        'meal_cost_total_cents',
        'insurance_rate_id',
        'insurance_cost_override_cents',
        'insurance_cost_cents',
        'transport_plate_rate_id',
        'transport_plate_cost_override_cents',
        'transport_plate_cost_cents',
        'fuel_type_id',
        'tolls_and_ferry_cents',
        'subtotal_cents',
        'tax_rate',
        'tax_amount_cents',
        'total_cents',
        'notes',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'fuel_economy_per_100km' => 'decimal:2',
            'tax_rate'               => 'decimal:4',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->ulid)) {
                $model->ulid = (string) Str::ulid();
            }
            $model->computeFields();
        });

        static::updating(function (self $model) {
            $model->computeFields();
        });
    }

    // ── Relationships ────────────────────────────────────────────────────────

    public function quoteRequest(): BelongsTo
    {
        return $this->belongsTo(QuoteRequest::class);
    }

    public function insuranceRate(): BelongsTo
    {
        return $this->belongsTo(InsuranceRate::class);
    }

    public function transportPlateRate(): BelongsTo
    {
        return $this->belongsTo(TransportPlateRate::class);
    }

    public function fuelType(): BelongsTo
    {
        return $this->belongsTo(FuelType::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function addOnServices(): BelongsToMany
    {
        return $this->belongsToMany(AddOnService::class, 'trip_plan_add_on_services')
            ->withPivot(['quantity', 'calculated_cost_cents', 'rate_type', 'unit_cost_cents'])
            ->withTimestamps();
    }

    // ── Scopes ───────────────────────────────────────────────────────────────

    public function scopeForQuoteRequest($query, int $quoteRequestId)
    {
        return $query->where('quote_request_id', $quoteRequestId);
    }

    // ── Computation ──────────────────────────────────────────────────────────

    /**
     * Recompute all derived fields. Called automatically on creating/updating.
     * May also be called manually after changing add-on services on the pivot.
     */
    public function recalculate(): void
    {
        $this->computeFields();
        $this->save();
    }

    public function computeFields(): void
    {
        // Distance calculations
        $this->adjusted_distance_km = floor($this->distance_km * (1 + $this->detour_buffer_pct / 100));
        
        // Timing calculations
        $this->km_per_day = $this->speed_kmh * $this->drive_hours_per_day;
        
        if ($this->km_per_day > 0) {
            $this->drive_days = floor($this->adjusted_distance_km / $this->km_per_day);
        } else {
            $this->drive_days = 0;
        }
        
        if ($this->delay_day_per_km > 0) {
            $this->delay_days = floor($this->adjusted_distance_km / $this->delay_day_per_km);
        } else {
            $this->delay_days = 0;
        }
        
        $this->total_days = $this->drive_days + $this->delay_days;
        $this->hotel_nights = max(0, $this->drive_days - 1);
        
        // Fuel cost
        $this->fuel_cost_cents = round(($this->adjusted_distance_km / 100) * $this->fuel_economy_per_100km * $this->avg_fuel_price_cents);
        
        // Driver cost
        $this->driver_cost_cents = round($this->adjusted_distance_km * $this->driver_rate_cents_per_km);
        
        // Hotel cost (drive days only: nights = drive_days - 1)
        $this->hotel_cost_cents = $this->hotel_nights * $this->hotel_rate_cents;
        
        // Meal cost (drive days only)
        $this->meal_cost_total_cents = $this->drive_days * $this->meals_per_day * $this->meal_cost_cents;
        
        // Insurance cost with override support
        if ($this->insurance_cost_override_cents !== null && $this->insurance_cost_override_cents > 0) {
            $this->insurance_cost_cents = $this->insurance_cost_override_cents * $this->total_days;
        } elseif ($this->insurance_rate_id) {
            $rate = InsuranceRate::find($this->insurance_rate_id);
            $this->insurance_cost_cents = $rate ? ($rate->daily_rate * $this->total_days) : 0;
        } else {
            $this->insurance_cost_cents = 0;
        }
        
        // Transport plate cost with override support
        if ($this->transport_plate_cost_override_cents !== null && $this->transport_plate_cost_override_cents > 0) {
            $this->transport_plate_cost_cents = $this->transport_plate_cost_override_cents * $this->total_days;
        } elseif ($this->transport_plate_rate_id) {
            $rate = TransportPlateRate::find($this->transport_plate_rate_id);
            $this->transport_plate_cost_cents = $rate ? ($rate->daily_rate * $this->total_days) : 0;
        } else {
            $this->transport_plate_cost_cents = 0;
        }
        
        // Subtotal (sum of all cost fields; add-ons handled separately via sync)
        $this->subtotal_cents = 
            $this->fuel_cost_cents +
            $this->driver_cost_cents +
            $this->hotel_cost_cents +
            $this->meal_cost_total_cents +
            $this->insurance_cost_cents +
            $this->transport_plate_cost_cents +
            $this->tolls_and_ferry_cents;
        
        // Tax calculation — tax_rate is a 4-decimal string, e.g. '0.0500'
        $this->tax_amount_cents = (int) round($this->subtotal_cents * (float) $this->tax_rate);
        
        // Total
        $this->total_cents = $this->subtotal_cents + $this->tax_amount_cents;
    }

}
