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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelUnit active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelUnit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelUnit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelUnit onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelUnit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelUnit whereAbbreviation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelUnit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelUnit whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelUnit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelUnit whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelUnit whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelUnit whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelUnit whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelUnit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelUnit withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelUnit withoutTrashed()
 * @mixin \Eloquent
 */
class FuelUnit extends Model
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