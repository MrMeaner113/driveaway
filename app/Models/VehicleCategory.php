<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
