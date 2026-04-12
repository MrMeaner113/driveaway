<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\TaxRate;

class Province extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'country_id',
        'name',
        'code',
        'timezone',
        'dst_observed',
        'is_active',
    ];

    protected $casts = [
        'dst_observed' => 'boolean',
        'is_active'    => 'boolean',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function taxRates()
    {
        return $this->hasMany(TaxRate::class);
    }
}
