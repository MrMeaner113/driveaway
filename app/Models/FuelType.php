<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property bool $is_active
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelType whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelType withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelType withoutTrashed()
 * @mixin \Eloquent
 */
class FuelType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}