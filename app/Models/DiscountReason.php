<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Quote> $quotes
 * @property-read int|null $quotes_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiscountReason newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiscountReason newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiscountReason query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiscountReason whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiscountReason whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiscountReason whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiscountReason whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DiscountReason extends Model
{
    protected $fillable = ['name'];

    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }
}
