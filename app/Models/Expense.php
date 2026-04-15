<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'work_order_id',
        'driver_id',
        'vehicle_id',
        'expense_category_id',
        'description',
        'amount',
        'expense_date',
        'receipt_path',
        'notes',
        'recorded_by',
    ];

    protected function casts(): array
    {
        return [
            'expense_date' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Expense $expense) {
            if (auth()->check()) {
                $expense->recorded_by = auth()->id();
            }
        });
    }

    // ── Relationships ────────────────────────────────────────────────────────

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    // ── Accessors ────────────────────────────────────────────────────────────

    protected function amountFormatted(): Attribute
    {
        return Attribute::get(fn () => '$' . number_format($this->amount / 100, 2));
    }

    // ── Scopes ───────────────────────────────────────────────────────────────

    public function scopeForWorkOrder(Builder $query, int $workOrderId): Builder
    {
        return $query->where('work_order_id', $workOrderId);
    }

    public function scopeByCategory(Builder $query, int $categoryId): Builder
    {
        return $query->where('expense_category_id', $categoryId);
    }

    public function scopeForDriver(Builder $query, int $driverId): Builder
    {
        return $query->where('driver_id', $driverId);
    }

    public function scopeForVehicle(Builder $query, int $vehicleId): Builder
    {
        return $query->where('vehicle_id', $vehicleId);
    }
}
