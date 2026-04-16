<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $color
 * @property string|null $description
 * @property bool $is_terminal
 * @property bool $is_active
 * @property int $sort_order
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteStatus active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteStatus nonTerminal()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteStatus terminal()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteStatus whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteStatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteStatus whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteStatus whereIsTerminal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteStatus whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteStatus whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteStatus withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteStatus withoutTrashed()
 * @mixin \Eloquent
 */
class QuoteStatus extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'color',
        'description',
        'is_terminal',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_terminal' => 'boolean',
        'is_active'   => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function scopeTerminal($query)
    {
        return $query->where('is_terminal', true);
    }

    public function scopeNonTerminal($query)
    {
        return $query->where('is_terminal', false);
    }
}