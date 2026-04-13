<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExpenseCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cra_t2125_id',
        'name',
        'slug',
        'driver_claimable',
        'reimbursable',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'driver_claimable' => 'boolean',
        'reimbursable'     => 'boolean',
        'is_active'        => 'boolean',
    ];

    // ── Relationships ────────────────────────────────────
    public function craLine()
    {
        return $this->belongsTo(CraT2125Line::class, 'cra_t2125_id');
    }

    // ── Scopes ───────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function scopeDriverClaimable($query)
    {
        return $query->where('driver_claimable', true);
    }
}