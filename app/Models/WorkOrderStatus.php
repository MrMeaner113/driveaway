<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkOrderStatus extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'color',
        'description',
        'visible_to_client',
        'is_terminal',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'visible_to_client' => 'boolean',
        'is_terminal'       => 'boolean',
        'is_active'         => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function scopeClientVisible($query)
    {
        return $query->where('visible_to_client', true);
    }

    public function scopeTerminal($query)
    {
        return $query->where('is_terminal', true);
    }

    public function scopeNonTerminal($query)
    {
        return $query->where('is_terminal', false);
    }
}