<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $description
 * @property bool $is_active
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TaxRate> $taxRates
 * @property-read int|null $tax_rates_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaxType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaxType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaxType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaxType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaxType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaxType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaxType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaxType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaxType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaxType whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaxType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaxType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaxType withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaxType withoutTrashed()
 * @mixin \Eloquent
 */
class TaxType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function taxRates()
    {
        return $this->hasMany(TaxRate::class);
    }
}