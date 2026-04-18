<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DriverStatus extends Model
{
    protected $fillable = ['name', 'color_code'];

    public function drivers(): HasMany
    {
        return $this->hasMany(Driver::class);
    }
}
