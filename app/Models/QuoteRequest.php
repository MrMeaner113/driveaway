<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $ulid
 * @property string $first_name
 * @property string $last_name
 * @property string|null $email
 * @property string|null $phone
 * @property int $origin_country_id
 * @property int|null $origin_province_id
 * @property int|null $origin_city_id
 * @property int $destination_country_id
 * @property int|null $destination_province_id
 * @property int|null $destination_city_id
 * @property \Carbon\CarbonImmutable|null $preferred_date
 * @property string|null $notes
 * @property string $status
 * @property \Carbon\CarbonImmutable|null $reviewed_at
 * @property \Carbon\CarbonImmutable|null $quoted_at
 * @property \Carbon\CarbonImmutable|null $accepted_at
 * @property \Carbon\CarbonImmutable|null $rejected_at
 * @property \Carbon\CarbonImmutable|null $expired_at
 * @property int|null $reviewed_by
 * @property int|null $quoted_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property string|null $origin_province_custom
 * @property string|null $origin_city_custom
 * @property string|null $destination_province_custom
 * @property string|null $destination_city_custom
 * @property string|null $rejected_reason
 * @property int|null $vehicle_category_id
 * @property string|null $notes_internal
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AddOnService> $addOnServices
 * @property-read int|null $add_on_services_count
 * @property-read \App\Models\City|null $destinationCity
 * @property-read \App\Models\Country|null $destinationCountry
 * @property-read \App\Models\Province|null $destinationProvince
 * @property-read string $destination_city_display
 * @property-read string $destination_province_display
 * @property-read string $full_name
 * @property-read string $origin_city_display
 * @property-read string $origin_province_display
 * @property-read \App\Models\City|null $originCity
 * @property-read \App\Models\Country|null $originCountry
 * @property-read \App\Models\Province|null $originProvince
 * @property-read \App\Models\User|null $quotedBy
 * @property-read \App\Models\User|null $reviewedBy
 * @property-read \App\Models\TripPlan|null $tripPlan
 * @property-read \App\Models\VehicleCategory|null $vehicleCategory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\QuoteRequestVehicle> $vehicles
 * @property-read int|null $vehicles_count
 * @method static Builder<static>|QuoteRequest accepted()
 * @method static Builder<static>|QuoteRequest new()
 * @method static Builder<static>|QuoteRequest newModelQuery()
 * @method static Builder<static>|QuoteRequest newQuery()
 * @method static Builder<static>|QuoteRequest onlyTrashed()
 * @method static Builder<static>|QuoteRequest pending()
 * @method static Builder<static>|QuoteRequest query()
 * @method static Builder<static>|QuoteRequest quoted()
 * @method static Builder<static>|QuoteRequest rejected()
 * @method static Builder<static>|QuoteRequest reviewed()
 * @method static Builder<static>|QuoteRequest whereAcceptedAt($value)
 * @method static Builder<static>|QuoteRequest whereCreatedAt($value)
 * @method static Builder<static>|QuoteRequest whereDeletedAt($value)
 * @method static Builder<static>|QuoteRequest whereDestinationCityCustom($value)
 * @method static Builder<static>|QuoteRequest whereDestinationCityId($value)
 * @method static Builder<static>|QuoteRequest whereDestinationCountryId($value)
 * @method static Builder<static>|QuoteRequest whereDestinationProvinceCustom($value)
 * @method static Builder<static>|QuoteRequest whereDestinationProvinceId($value)
 * @method static Builder<static>|QuoteRequest whereEmail($value)
 * @method static Builder<static>|QuoteRequest whereExpiredAt($value)
 * @method static Builder<static>|QuoteRequest whereFirstName($value)
 * @method static Builder<static>|QuoteRequest whereId($value)
 * @method static Builder<static>|QuoteRequest whereLastName($value)
 * @method static Builder<static>|QuoteRequest whereNotes($value)
 * @method static Builder<static>|QuoteRequest whereNotesInternal($value)
 * @method static Builder<static>|QuoteRequest whereOriginCityCustom($value)
 * @method static Builder<static>|QuoteRequest whereOriginCityId($value)
 * @method static Builder<static>|QuoteRequest whereOriginCountryId($value)
 * @method static Builder<static>|QuoteRequest whereOriginProvinceCustom($value)
 * @method static Builder<static>|QuoteRequest whereOriginProvinceId($value)
 * @method static Builder<static>|QuoteRequest wherePhone($value)
 * @method static Builder<static>|QuoteRequest wherePreferredDate($value)
 * @method static Builder<static>|QuoteRequest whereQuotedAt($value)
 * @method static Builder<static>|QuoteRequest whereQuotedBy($value)
 * @method static Builder<static>|QuoteRequest whereRejectedAt($value)
 * @method static Builder<static>|QuoteRequest whereRejectedReason($value)
 * @method static Builder<static>|QuoteRequest whereReviewedAt($value)
 * @method static Builder<static>|QuoteRequest whereReviewedBy($value)
 * @method static Builder<static>|QuoteRequest whereStatus($value)
 * @method static Builder<static>|QuoteRequest whereUlid($value)
 * @method static Builder<static>|QuoteRequest whereUpdatedAt($value)
 * @method static Builder<static>|QuoteRequest whereVehicleCategoryId($value)
 * @method static Builder<static>|QuoteRequest withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|QuoteRequest withUnresolvedFields()
 * @method static Builder<static>|QuoteRequest withoutTrashed()
 * @mixin \Eloquent
 */
class QuoteRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ulid',
        'first_name',
        'last_name',
        'email',
        'phone',
        'origin_country_id',
        'origin_province_id',
        'origin_province_custom',
        'origin_city_id',
        'origin_city_custom',
        'destination_country_id',
        'destination_province_id',
        'destination_province_custom',
        'destination_city_id',
        'destination_city_custom',
        'preferred_date',
        'date_type',
        'quote_number',
        'notes',
        'rejected_reason',
        'status',
        'reviewed_at',
        'quoted_at',
        'accepted_at',
        'rejected_at',
        'expired_at',
        'reviewed_by',
        'quoted_by',
        'vehicle_category_id',
        'notes_internal',
    ];

    protected function casts(): array
    {
        return [
            'preferred_date' => 'date',
            'reviewed_at'    => 'datetime',
            'quoted_at'      => 'datetime',
            'accepted_at'    => 'datetime',
            'rejected_at'    => 'datetime',
            'expired_at'     => 'datetime',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model) {
            if (empty($model->ulid)) {
                $model->ulid = (string) Str::ulid();
            }
        });
    }

    // ── Relationships ────────────────────────────────────────────────────────

    public function originCountry(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'origin_country_id');
    }

    public function originProvince(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'origin_province_id');
    }

    public function originCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'origin_city_id');
    }

    public function destinationCountry(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'destination_country_id');
    }

    public function destinationProvince(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'destination_province_id');
    }

    public function destinationCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'destination_city_id');
    }

    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function quotedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'quoted_by');
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(QuoteRequestVehicle::class);
    }

    public function addOnServices(): BelongsToMany
    {
        return $this->belongsToMany(AddOnService::class, 'quote_request_add_on_services');
    }

    public function vehicleCategory(): BelongsTo
    {
        return $this->belongsTo(VehicleCategory::class);
    }

    public function tripPlan(): HasOne
    {
        return $this->hasOne(TripPlan::class);
    }

    // ── Accessors ────────────────────────────────────────────────────────────

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /** Human-readable origin city — FK label if resolved, else free-text custom value. */
    public function getOriginCityDisplayAttribute(): string
    {
        return $this->originCity?->name ?? $this->origin_city_custom ?? '';
    }

    /** Human-readable origin province — FK label if resolved, else free-text custom value. */
    public function getOriginProvinceDisplayAttribute(): string
    {
        return $this->originProvince?->name ?? $this->origin_province_custom ?? '';
    }

    /** Human-readable destination city — FK label if resolved, else free-text custom value. */
    public function getDestinationCityDisplayAttribute(): string
    {
        return $this->destinationCity?->name ?? $this->destination_city_custom ?? '';
    }

    /** Human-readable destination province — FK label if resolved, else free-text custom value. */
    public function getDestinationProvinceDisplayAttribute(): string
    {
        return $this->destinationProvince?->name ?? $this->destination_province_custom ?? '';
    }

    // ── Scopes ───────────────────────────────────────────────────────────────

    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeReviewed($query)
    {
        return $query->where('status', 'reviewed');
    }

    public function scopeQuoted($query)
    {
        return $query->where('status', 'quoted');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', ['new', 'reviewed', 'quoted']);
    }

    /**
     * Requests where any _custom field is filled but the corresponding _id is still null
     * (i.e. the city/province/vehicle has not yet been resolved to a lookup record).
     */
    public function scopeWithUnresolvedFields(Builder $query): Builder
    {
        return $query->where(function (Builder $q) {
            $q->where(fn ($s) => $s->whereNotNull('origin_city_custom')->whereNull('origin_city_id'))
              ->orWhere(fn ($s) => $s->whereNotNull('origin_province_custom')->whereNull('origin_province_id'))
              ->orWhere(fn ($s) => $s->whereNotNull('destination_city_custom')->whereNull('destination_city_id'))
              ->orWhere(fn ($s) => $s->whereNotNull('destination_province_custom')->whereNull('destination_province_id'))
              ->orWhereHas('vehicles', fn ($v) => $v
                  ->where(fn ($s) => $s->whereNotNull('vehicle_make_custom')->whereNull('vehicle_make_id'))
                  ->orWhere(fn ($s) => $s->whereNotNull('vehicle_model_custom')->whereNull('vehicle_model_id'))
              );
        });
    }

    // ── Helpers ──────────────────────────────────────────────────────────────

    public static function generateQuoteNumber(): string
    {
        $date  = now()->format('myd');
        $count = static::whereDate('created_at', today())->count() + 1;

        return $date . '-' . $count;
    }

    public function isTerminal(): bool
    {
        return in_array($this->status, ['accepted', 'rejected', 'cancelled', 'converted']);
    }

    /**
     * Returns true if any city, province, or vehicle field has free-text
     * that has not yet been linked to a lookup record.
     */
    public function hasUnresolvedFields(): bool
    {
        if (($this->origin_city_custom && ! $this->origin_city_id) ||
            ($this->origin_province_custom && ! $this->origin_province_id) ||
            ($this->destination_city_custom && ! $this->destination_city_id) ||
            ($this->destination_province_custom && ! $this->destination_province_id)) {
            return true;
        }

        return $this->vehicles->contains(fn ($v) => ! $v->isResolved());
    }
}
