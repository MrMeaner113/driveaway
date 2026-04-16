<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $unit_label
 * @property string|null $description
 * @property bool $is_active
 * @property int $sort_order
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RateType active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RateType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RateType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RateType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RateType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RateType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RateType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RateType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RateType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RateType whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RateType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RateType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RateType whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RateType whereUnitLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RateType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RateType withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RateType withoutTrashed()
 * @mixin \Eloquent
 */
class RateType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'unit_label',
        'description',
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