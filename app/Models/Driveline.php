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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driveline newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driveline newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driveline onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driveline query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driveline whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driveline whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driveline whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driveline whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driveline whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driveline whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driveline whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driveline withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driveline withoutTrashed()
 * @mixin \Eloquent
 */
class Driveline extends Model
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