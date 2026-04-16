<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property bool $is_active
 * @property int $sort_order
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property string $rate_type
 * @property int $base_rate
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddOnService active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddOnService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddOnService newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddOnService onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddOnService query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddOnService whereBaseRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddOnService whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddOnService whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddOnService whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddOnService whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddOnService whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddOnService whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddOnService whereRateType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddOnService whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddOnService whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddOnService whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddOnService withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddOnService withoutTrashed()
 * @mixin \Eloquent
 */
class AddOnService extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
        'sort_order',
        'rate_type',
        'base_rate',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}