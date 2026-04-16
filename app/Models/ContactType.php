<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $contact_category_id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property bool $is_active
 * @property int $sort_order
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\ContactCategory|null $category
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactType active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactType whereContactCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactType whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactType whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactType withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactType withoutTrashed()
 * @mixin \Eloquent
 */
class ContactType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'contact_category_id',
        'name',
        'slug',
        'description',
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

    public function category()
    {
        return $this->belongsTo(ContactCategory::class, 'contact_category_id');
    }
}