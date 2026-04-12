<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'iso_code',
        'postal_format',
        'requires_jurisdiction',
        'is_active',
        'is_default',
    ];

    protected $casts = [
        'requires_jurisdiction' => 'boolean',
        'is_active'             => 'boolean',
        'is_default'            => 'boolean',
    ];

    public function provinces()
    {
        return $this->hasMany(Province::class);
    }
}