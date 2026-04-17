<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TripPlanExtraTravel extends Model
{
    protected $table = 'trip_plan_extra_travel';

    protected $fillable = [
        'trip_plan_id',
        'travel_mode_id',
        'description',
        'charge',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'charge' => 'decimal:2',
        ];
    }

    public function tripPlan(): BelongsTo
    {
        return $this->belongsTo(TripPlan::class);
    }

    public function travelMode(): BelongsTo
    {
        return $this->belongsTo(TravelMode::class);
    }
}
