<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CraT2125Line extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cra_t2125_lines';

    protected $fillable = [
        'line_number',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ── Scopes ──────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('line_number');
    }

    // ── Relationships ────────────────────────────────────
    public function expenseCategories()
    {
        return $this->hasMany(ExpenseCategory::class, 'cra_t2125_id');
    }

    // ── Accessors ────────────────────────────────────────
    public function getLabelAttribute(): string
    {
        return $this->line_number . ' — ' . $this->description;
    }
}