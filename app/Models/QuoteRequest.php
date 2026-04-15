<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

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
