<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $cra_t2125_id
 * @property string $name
 * @property string $slug
 * @property bool $driver_claimable
 * @property bool $reimbursable
 * @property bool $is_active
 * @property int $sort_order
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property string $type
 * @property-read \App\Models\CraT2125Line|null $craLine
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExpenseCategory active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExpenseCategory driverClaimable()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExpenseCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExpenseCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExpenseCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExpenseCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExpenseCategory whereCraT2125Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExpenseCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExpenseCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExpenseCategory whereDriverClaimable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExpenseCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExpenseCategory whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExpenseCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExpenseCategory whereReimbursable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExpenseCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExpenseCategory whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExpenseCategory whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExpenseCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExpenseCategory withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExpenseCategory withoutTrashed()
 * @mixin \Eloquent
 */
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