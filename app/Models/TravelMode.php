<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TravelMode extends Model
{
    protected $fillable = ['name', 'icon'];

    public function driverTravel(): HasMany
    {
        return $this->hasMany(DriverTravel::class);
    }
}
