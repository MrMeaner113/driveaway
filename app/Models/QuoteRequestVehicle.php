<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuoteRequestVehicle extends Model
{
    protected $fillable = [
        'quote_request_id',
        'vehicle_year',
        'vehicle_make_id',
        'vehicle_make_custom',
        'vehicle_model_id',
        'vehicle_model_custom',
        // Post-acceptance details
        'vehicle_vin',
        'vehicle_colour',
        'license_plate',
        'license_province',
        'is_licensed',
        'requires_transport_plates',
        'modifications',
        'mileage',
    ];

    protected function casts(): array
    {
        return [
            'is_licensed'               => 'boolean',
            'requires_transport_plates' => 'boolean',
        ];
    }

    // ── Relationships ────────────────────────────────────────────────────────

    public function quoteRequest(): BelongsTo
    {
        return $this->belongsTo(QuoteRequest::class);
    }

    public function vehicleMake(): BelongsTo
    {
        return $this->belongsTo(VehicleMake::class);
    }

    public function vehicleModel(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class);
    }

    // ── Accessors ────────────────────────────────────────────────────────────

    /** FK label if resolved to a lookup make, else the free-text custom value. */
    public function getVehicleMakeDisplayAttribute(): string
    {
        return $this->vehicleMake?->name ?? $this->vehicle_make_custom ?? '';
    }

    /** FK label if resolved to a lookup model, else the free-text custom value. */
    public function getVehicleModelDisplayAttribute(): string
    {
        return $this->vehicleModel?->name ?? $this->vehicle_model_custom ?? '';
    }

    // ── Helpers ──────────────────────────────────────────────────────────────

    /**
     * True when both make and model have a value — either a resolved FK
     * or a custom free-text string entered by the client.
     *
     * False only when a field is completely blank (no ID and no custom text).
     * Use this to distinguish "vehicle has a value for each field" from
     * "vehicle has an unresolved custom value pending staff approval".
     */
    public function isResolved(): bool
    {
        $makeOk  = $this->vehicle_make_id !== null || filled($this->vehicle_make_custom);
        $modelOk = $this->vehicle_model_id !== null || filled($this->vehicle_model_custom);

        return $makeOk && $modelOk;
    }

    /**
     * True when either make or model has free-text that has not yet been
     * linked to a lookup record — i.e., pending staff resolution.
     */
    public function hasPendingCustomFields(): bool
    {
        return ($this->vehicle_make_custom && ! $this->vehicle_make_id)
            || ($this->vehicle_model_custom && ! $this->vehicle_model_id);
    }
}
