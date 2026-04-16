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
 * @property bool $visible_to_client
 * @property bool $is_terminal
 * @property bool $is_active
 * @property int $sort_order
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderStatus active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderStatus clientVisible()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderStatus nonTerminal()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderStatus terminal()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderStatus whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderStatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderStatus whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderStatus whereIsTerminal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderStatus whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderStatus whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderStatus whereVisibleToClient($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderStatus withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderStatus withoutTrashed()
 * @mixin \Eloquent
 */
class WorkOrderStatus extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'color',
        'description',
        'visible_to_client',
        'is_terminal',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'visible_to_client' => 'boolean',
        'is_terminal'       => 'boolean',
        'is_active'         => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function scopeClientVisible($query)
    {
        return $query->where('visible_to_client', true);
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