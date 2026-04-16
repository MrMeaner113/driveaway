<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\InsuranceRate> $insuranceRates
 * @property-read int|null $insurance_rates_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\QuoteRequest> $quoteRequests
 * @property-read int|null $quote_requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Quote> $quotes
 * @property-read int|null $quotes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TransportPlateRate> $transportPlateRates
 * @property-read int|null $transport_plate_rates_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class VehicleCategory extends Model
{
    protected $fillable = ['name', 'description'];

    public function transportPlateRates(): HasMany
    {
        return $this->hasMany(TransportPlateRate::class);
    }

    public function insuranceRates(): HasMany
    {
        return $this->hasMany(InsuranceRate::class);
    }

    public function quoteRequests(): HasMany
    {
        return $this->hasMany(QuoteRequest::class);
    }

    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }
}
