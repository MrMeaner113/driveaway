<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $address_type_id
 * @property int|null $contact_id
 * @property int|null $organization_id
 * @property string $line1
 * @property string|null $line2
 * @property int $city_id
 * @property int $province_id
 * @property int $country_id
 * @property string $postal_code
 * @property bool $is_primary
 * @property bool $is_active
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read \App\Models\AddressType|null $addressType
 * @property-read \App\Models\City|null $city
 * @property-read \App\Models\Contact|null $contact
 * @property-read \App\Models\Country|null $country
 * @property-read \App\Models\Organization|null $organization
 * @property-read \App\Models\Province|null $province
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereAddressTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereIsPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereLine1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereLine2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address withoutTrashed()
 * @mixin \Eloquent
 */
class Address extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'address_type_id',
        'contact_id',
        'organization_id',
        'line1',
        'line2',
        'city_id',
        'province_id',
        'country_id',
        'postal_code',
        'is_primary',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
            'is_active'  => 'boolean',
        ];
    }

    public function addressType(): BelongsTo
    {
        return $this->belongsTo(AddressType::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function getFormattedAttribute(): string
    {
        $parts = array_filter([
            $this->line1,
            $this->line2,
            $this->city?->name,
            trim(($this->province?->code ?? '') . ' ' . ($this->postal_code ?? '')),
            $this->country?->name,
        ]);
        return implode(', ', $parts);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function (Address $address) {
            if (! $address->is_primary) {
                return;
            }

            $query = Address::query()->where('id', '!=', $address->id ?? 0);

            if ($address->contact_id) {
                $query->where('contact_id', $address->contact_id)->update(['is_primary' => false]);
            } elseif ($address->organization_id) {
                $query->where('organization_id', $address->organization_id)->update(['is_primary' => false]);
            }
        });
    }
}
