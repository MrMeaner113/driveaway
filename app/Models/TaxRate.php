<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaxRate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'province_id',
        'tax_type_id',
        'rate_pct',
        'effective_date',
        'expiry_date',
        'is_active',
    ];

    protected $casts = [
        'effective_date' => 'date',
        'expiry_date'    => 'date',
        'is_active'      => 'boolean',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function taxType()
    {
        return $this->belongsTo(TaxType::class);
    }
}