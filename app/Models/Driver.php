<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'license_number',
        'license_class',
        'issuing_jurisdiction_id',
        'license_expiry',
        'has_air_brakes',
        'has_passenger',
        'manual_shift',
        'medical_cert_expiry',
        'abstract_date',
        'restrictions',
    ];

    protected function casts(): array
    {
        return [
            'license_expiry'      => 'date',
            'medical_cert_expiry' => 'date',
            'abstract_date'       => 'date',
            'has_air_brakes'      => 'boolean',
            'has_passenger'       => 'boolean',
            'manual_shift'        => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function issuingJurisdiction(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'issuing_jurisdiction_id');
    }
}
