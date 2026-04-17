<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class TripPlan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ulid',
        'quote_request_id',
        'driver_id',
        'vehicle_id',
        'origin_contact_id',
        'destination_contact_id',
        'pickup_date',
        'latest_delivery_date',
        // Route
        'distance_km',
        'detour_pct',
        'out_of_route_km',
        'adjusted_distance_km',
        // Duration
        'avg_speed_kph',
        'drive_hours',
        'drive_days',
        'drive_days_override',
        'nights',
        'ferry_involved',
        'extended_drive_time',
        'extended_drive_time_override',
        // Fuel
        'fuel_type_id',
        'fuel_economy_l100',
        'estimated_fuel_litres',
        'fuel_price_per_litre',
        'fuel_cost',
        // Driver
        'rate_type_id',
        'driver_rate_per_km',
        'driver_cost',
        // Accommodations & Meals
        'hotel_rate',
        'accommodations_cost',
        'meal_rate',
        'meals_per_day',
        'meals_cost',
        // Discount
        'discount_reason_id',
        'discount_type',
        'discount_value',
        'discount_amount',
        // Currency & Tax
        'currency',
        'fx_rate',
        'tax_type_id',
        'tax_rate',
        'cc_rate',
        // Totals
        'line_total',
        'subtotal',
        'tax_amount',
        'cc_fee',
        'total',
        'notes',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'pickup_date'                  => 'date',
            'latest_delivery_date'         => 'date',
            'drive_days_override'          => 'boolean',
            'ferry_involved'               => 'boolean',
            'extended_drive_time_override' => 'boolean',
            'distance_km'                  => 'decimal:2',
            'detour_pct'                   => 'decimal:4',
            'out_of_route_km'              => 'decimal:2',
            'adjusted_distance_km'         => 'decimal:2',
            'avg_speed_kph'                => 'decimal:1',
            'drive_hours'                  => 'decimal:2',
            'fuel_economy_l100'            => 'decimal:2',
            'estimated_fuel_litres'        => 'decimal:2',
            'fuel_price_per_litre'         => 'decimal:4',
            'fuel_cost'                    => 'decimal:2',
            'driver_rate_per_km'           => 'decimal:4',
            'driver_cost'                  => 'decimal:2',
            'hotel_rate'                   => 'decimal:2',
            'accommodations_cost'          => 'decimal:2',
            'meal_rate'                    => 'decimal:2',
            'meals_cost'                   => 'decimal:2',
            'discount_value'               => 'decimal:2',
            'discount_amount'              => 'decimal:2',
            'fx_rate'                      => 'decimal:6',
            'tax_rate'                     => 'decimal:4',
            'cc_rate'                      => 'decimal:4',
            'line_total'                   => 'decimal:2',
            'subtotal'                     => 'decimal:2',
            'tax_amount'                   => 'decimal:2',
            'cc_fee'                       => 'decimal:2',
            'total'                        => 'decimal:2',
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

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function originContact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'origin_contact_id');
    }

    public function destinationContact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'destination_contact_id');
    }

    public function taxType(): BelongsTo
    {
        return $this->belongsTo(TaxType::class);
    }

    public function rateType(): BelongsTo
    {
        return $this->belongsTo(RateType::class);
    }

    public function discountReason(): BelongsTo
    {
        return $this->belongsTo(DiscountReason::class);
    }

    public function fuelType(): BelongsTo
    {
        return $this->belongsTo(FuelType::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tripPlanAddOnServices(): HasMany
    {
        return $this->hasMany(TripPlanAddOnService::class)->orderBy('sort_order');
    }

    public function tripPlanExtraTravel(): HasMany
    {
        return $this->hasMany(TripPlanExtraTravel::class)->orderBy('sort_order');
    }

    // ── Scopes ───────────────────────────────────────────────────────────────

    public function scopeForQuoteRequest($query, int $quoteRequestId)
    {
        return $query->where('quote_request_id', $quoteRequestId);
    }

    // ── Business Logic ───────────────────────────────────────────────────────

    /**
     * Tiered detour percentage based on distance_km.
     * < 1,000 km = 5%  |  1,000–4,499 km = 10%  |  4,500+ km = 15%
     */
    public function detourPercentage(): float
    {
        $km = (float) $this->distance_km;
        if ($km < 1000) return 0.05;
        if ($km < 4500) return 0.10;
        return 0.15;
    }

    public function discountAmount(): float
    {
        return match ($this->discount_type) {
            'flat'    => (float) ($this->discount_value ?? 0),
            'percent' => round($this->lineTotal() * (float) ($this->discount_value ?? 0) / 100, 2),
            default   => 0.0,
        };
    }

    public function lineTotal(): float
    {
        $direct = (float) $this->fuel_cost
            + (float) $this->driver_cost
            + (float) $this->accommodations_cost
            + (float) $this->meals_cost;

        $addOns      = $this->exists ? (float) $this->tripPlanAddOnServices()->sum('charge') : 0.0;
        $extraTravel = $this->exists ? (float) $this->tripPlanExtraTravel()->sum('charge') : 0.0;

        return round($direct + $addOns + $extraTravel, 2);
    }

    /** Recalculate and persist. Call after changing add-on services or extra travel. */
    public function recalculate(): void
    {
        $this->computeFields();
        $this->save();
    }

    public function computeFields(): void
    {
        // ── Route ─────────────────────────────────────────────────────────────
        $this->detour_pct           = $this->detourPercentage();
        $this->out_of_route_km      = round((float) $this->distance_km * $this->detour_pct, 2);
        $this->adjusted_distance_km = round((float) $this->distance_km + $this->out_of_route_km, 2);

        // ── Duration ──────────────────────────────────────────────────────────
        $speed            = (float) ($this->avg_speed_kph ?: 90);
        $this->drive_hours = round($this->adjusted_distance_km / $speed, 2);

        if (! $this->drive_days_override) {
            $this->drive_days = (int) floor($this->drive_hours / 12);
        }

        $this->nights = (int) floor($this->drive_hours / 10);

        if (! $this->extended_drive_time_override) {
            $this->extended_drive_time = $this->nights + ($this->ferry_involved ? 3 : 2);
        }

        if ($this->pickup_date && $this->extended_drive_time > 0) {
            $this->latest_delivery_date = Carbon::parse($this->pickup_date)
                ->addDays($this->extended_drive_time)
                ->toDateString();
        }

        // ── Fuel ──────────────────────────────────────────────────────────────
        $this->estimated_fuel_litres = round($this->adjusted_distance_km * (float) $this->fuel_economy_l100 / 100, 2);
        $this->fuel_cost             = round($this->estimated_fuel_litres * (float) $this->fuel_price_per_litre, 2);

        // ── Driver ────────────────────────────────────────────────────────────
        $this->driver_cost = round($this->adjusted_distance_km * (float) $this->driver_rate_per_km, 2);

        // ── Accommodations & Meals ────────────────────────────────────────────
        $this->accommodations_cost = round($this->nights * (float) $this->hotel_rate, 2);
        $this->meals_cost          = round($this->nights * $this->meals_per_day * (float) $this->meal_rate, 2);

        // ── Totals ────────────────────────────────────────────────────────────
        $direct = $this->fuel_cost + $this->driver_cost + $this->accommodations_cost + $this->meals_cost;
        $addOns = $this->exists ? (float) $this->tripPlanAddOnServices()->sum('charge') : 0.0;
        $extra  = $this->exists ? (float) $this->tripPlanExtraTravel()->sum('charge') : 0.0;

        $this->line_total      = round($direct + $addOns + $extra, 2);
        $this->discount_amount = $this->discountAmount();
        $this->subtotal        = round($this->line_total - $this->discount_amount, 2);
        $this->tax_amount      = round($this->subtotal * (float) $this->tax_rate, 2);
        $this->cc_fee          = round($this->subtotal * (float) $this->cc_rate, 2);
        $this->total           = round($this->subtotal + $this->tax_amount + $this->cc_fee, 2);
    }

    // ── Display Helpers ──────────────────────────────────────────────────────

    /** Convert a metric value to imperial for display only — never mutates stored values. */
    public function toImperial(string $field): float
    {
        return match ($field) {
            'distance_km', 'adjusted_distance_km', 'out_of_route_km' => round((float) $this->$field * 0.621371, 2),
            'avg_speed_kph'      => round((float) $this->avg_speed_kph * 0.621371, 1),
            'fuel_economy_l100'  => round(235.214 / (float) $this->fuel_economy_l100, 2),
            'estimated_fuel_litres' => round((float) $this->estimated_fuel_litres / 3.78541, 2),
            default => (float) $this->$field,
        };
    }

    /** Apply FX rate for display — never mutates stored values. */
    public function toUsd(float $amount): float
    {
        if ($this->currency === 'CAD' || ! $this->fx_rate) {
            return $amount;
        }
        return round($amount * (float) $this->fx_rate, 2);
    }
}
