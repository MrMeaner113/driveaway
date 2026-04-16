<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $sort_order
 * @property bool $is_active
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contact> $contacts
 * @property-read int|null $contacts_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactStatus whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactStatus whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactStatus whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactStatus withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactStatus withoutTrashed()
 * @mixin \Eloquent
 */
class ContactStatus extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }
}
