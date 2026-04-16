<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property bool $is_active
 * @property int $sort_order
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PreferredContactMethod active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PreferredContactMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PreferredContactMethod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PreferredContactMethod onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PreferredContactMethod query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PreferredContactMethod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PreferredContactMethod whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PreferredContactMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PreferredContactMethod whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PreferredContactMethod whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PreferredContactMethod whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PreferredContactMethod whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PreferredContactMethod whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PreferredContactMethod withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PreferredContactMethod withoutTrashed()
 * @mixin \Eloquent
 */
class PreferredContactMethod extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
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