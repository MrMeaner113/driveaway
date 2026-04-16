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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistanceUnit active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistanceUnit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistanceUnit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistanceUnit onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistanceUnit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistanceUnit whereAbbreviation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistanceUnit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistanceUnit whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistanceUnit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistanceUnit whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistanceUnit whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistanceUnit whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistanceUnit whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistanceUnit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistanceUnit withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistanceUnit withoutTrashed()
 * @mixin \Eloquent
 */
class DistanceUnit extends Model
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