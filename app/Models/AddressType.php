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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddressType active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddressType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddressType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddressType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddressType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddressType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddressType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddressType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddressType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddressType whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddressType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddressType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddressType whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddressType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddressType withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AddressType withoutTrashed()
 * @mixin \Eloquent
 */
class AddressType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
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