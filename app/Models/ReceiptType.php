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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReceiptType active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReceiptType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReceiptType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReceiptType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReceiptType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReceiptType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReceiptType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReceiptType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReceiptType whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReceiptType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReceiptType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReceiptType whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReceiptType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReceiptType withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReceiptType withoutTrashed()
 * @mixin \Eloquent
 */
class ReceiptType extends Model
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