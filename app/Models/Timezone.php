<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $name
 * @property string $timezone
 * @property bool $is_active
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone withoutTrashed()
 * @mixin \Eloquent
 */
class Timezone extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'timezone',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}