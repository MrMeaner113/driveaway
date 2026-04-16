<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $province_id
 * @property int $tax_type_id
 * @property int $rate_pct
 * @property \Carbon\CarbonImmutable $effective_date
 * @property \Carbon\CarbonImmutable|null $expiry_date
 * @property bool $is_active
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read \App\Models\Province|null $province
 * @property-read \App\Models\TaxType|null $taxType
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaxRate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaxRate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaxRate onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaxRate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaxRate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaxRate whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaxRate whereEffectiveDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaxRate whereExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaxRate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaxRate whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaxRate whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaxRate whereRatePct($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaxRate whereTaxTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaxRate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaxRate withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaxRate withoutTrashed()
 * @mixin \Eloquent
 */
class TaxRate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'province_id',
        'tax_type_id',
        'rate_pct',
        'effective_date',
        'expiry_date',
        'is_active',
    ];

    protected $casts = [
        'effective_date' => 'date',
        'expiry_date'    => 'date',
        'is_active'      => 'boolean',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function taxType()
    {
        return $this->belongsTo(TaxType::class);
    }
}