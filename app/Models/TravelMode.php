<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string|null $icon
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DriverTravel> $driverTravel
 * @property-read int|null $driver_travel_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TravelMode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TravelMode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TravelMode query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TravelMode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TravelMode whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TravelMode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TravelMode whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TravelMode whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TravelMode extends Model
{
    protected $fillable = ['name', 'icon'];

    public function driverTravel(): HasMany
    {
        return $this->hasMany(DriverTravel::class);
    }
}
