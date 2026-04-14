<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'vehicle_year',
        'vehicle_make',
        'vehicle_model',
        'origin_city',
        'origin_province_id',
        'destination_city',
        'destination_province_id',
        'requested_date',
        'status',
    ];

    protected $casts = [
        'requested_date' => 'date',
    ];

    public function originProvince()
    {
        return $this->belongsTo(Province::class, 'origin_province_id');
    }

    public function destinationProvince()
    {
        return $this->belongsTo(Province::class, 'destination_province_id');
    }
}
