<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $abbreviation
 * @property bool $is_active
 * @property int $sort_order
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelEfficiencyUnit active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelEfficiencyUnit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelEfficiencyUnit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelEfficiencyUnit onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelEfficiencyUnit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelEfficiencyUnit whereAbbreviation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelEfficiencyUnit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelEfficiencyUnit whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelEfficiencyUnit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelEfficiencyUnit whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelEfficiencyUnit whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelEfficiencyUnit whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelEfficiencyUnit whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelEfficiencyUnit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelEfficiencyUnit withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelEfficiencyUnit withoutTrashed()
 * @mixin \Eloquent
 */
class FuelEfficiencyUnit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'abbreviation',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}