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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContactType> $contactTypes
 * @property-read int|null $contact_types_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactCategory active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactCategory whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactCategory whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactCategory withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactCategory withoutTrashed()
 * @mixin \Eloquent
 */
class ContactCategory extends Model
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

    public function contactTypes()
    {
        return $this->hasMany(ContactType::class);
    }
}