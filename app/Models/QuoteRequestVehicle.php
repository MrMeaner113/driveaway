<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $quote_request_id
 * @property int $vehicle_year
 * @property string|null $vehicle_make_custom
 * @property string|null $vehicle_model_custom
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property int|null $vehicle_make_id
 * @property int|null $vehicle_model_id
 * @property string|null $vehicle_vin
 * @property string|null $vehicle_colour
 * @property string|null $license_plate
 * @property string|null $license_province
 * @property bool $is_licensed
 * @property bool $requires_transport_plates
 * @property string|null $modifications
 * @property int|null $mileage
 * @property-read string $vehicle_make_display
 * @property-read string $vehicle_model_display
 * @property-read \App\Models\QuoteRequest|null $quoteRequest
 * @property-read \App\Models\VehicleMake|null $vehicleMake
 * @property-read \App\Models\VehicleModel|null $vehicleModel
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequestVehicle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequestVehicle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequestVehicle query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequestVehicle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequestVehicle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequestVehicle whereIsLicensed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequestVehicle whereLicensePlate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequestVehicle whereLicenseProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequestVehicle whereMileage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequestVehicle whereModifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequestVehicle whereQuoteRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequestVehicle whereRequiresTransportPlates($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequestVehicle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequestVehicle whereVehicleColour($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequestVehicle whereVehicleMakeCustom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequestVehicle whereVehicleMakeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequestVehicle whereVehicleModelCustom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequestVehicle whereVehicleModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequestVehicle whereVehicleVin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequestVehicle whereVehicleYear($value)
 * @mixin \Eloquent
 */
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
