<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiscountReason extends Model
{
    protected $fillable = ['name'];

    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }
}
