<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

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
