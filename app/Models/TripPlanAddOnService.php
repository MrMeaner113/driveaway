<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TripPlanAddOnService extends Model
{
    protected $table = 'trip_plan_add_on_services';

    protected $fillable = [
        'trip_plan_id',
        'add_on_service_id',
        'description',
        'rate',
        'charge',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'rate'   => 'decimal:2',
            'charge' => 'decimal:2',
        ];
    }

    public function tripPlan(): BelongsTo
    {
        return $this->belongsTo(TripPlan::class);
    }

    public function addOnService(): BelongsTo
    {
        return $this->belongsTo(AddOnService::class);
    }
}
