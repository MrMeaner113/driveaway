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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelVendor active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelVendor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelVendor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelVendor onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelVendor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelVendor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelVendor whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelVendor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelVendor whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelVendor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelVendor whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelVendor whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelVendor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelVendor withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelVendor withoutTrashed()
 * @mixin \Eloquent
 */
class FuelVendor extends Model
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