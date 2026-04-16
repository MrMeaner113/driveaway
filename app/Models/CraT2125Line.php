<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $line_number
 * @property string $description
 * @property bool $is_active
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExpenseCategory> $expenseCategories
 * @property-read int|null $expense_categories_count
 * @property-read string $label
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CraT2125Line active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CraT2125Line newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CraT2125Line newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CraT2125Line onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CraT2125Line query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CraT2125Line whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CraT2125Line whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CraT2125Line whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CraT2125Line whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CraT2125Line whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CraT2125Line whereLineNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CraT2125Line whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CraT2125Line withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CraT2125Line withoutTrashed()
 * @mixin \Eloquent
 */
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