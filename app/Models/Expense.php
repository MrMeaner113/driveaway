<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $work_order_id
 * @property int $driver_id
 * @property int $expense_category_id
 * @property int|null $vendor_id
 * @property int $receipt_type_id
 * @property int $payment_method_id
 * @property int $amount
 * @property string $receipt_date
 * @property int $is_reimbursable
 * @property string|null $notes
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read mixed $amount_formatted
 * @property-read \App\Models\ExpenseCategory|null $category
 * @property-read \App\Models\Driver|null $driver
 * @property-read \App\Models\User|null $recordedBy
 * @property-read \App\Models\Vehicle|null $vehicle
 * @property-read \App\Models\WorkOrder|null $workOrder
 * @method static Builder<static>|Expense byCategory(int $categoryId)
 * @method static Builder<static>|Expense forDriver(int $driverId)
 * @method static Builder<static>|Expense forVehicle(int $vehicleId)
 * @method static Builder<static>|Expense forWorkOrder(int $workOrderId)
 * @method static Builder<static>|Expense newModelQuery()
 * @method static Builder<static>|Expense newQuery()
 * @method static Builder<static>|Expense onlyTrashed()
 * @method static Builder<static>|Expense query()
 * @method static Builder<static>|Expense whereAmount($value)
 * @method static Builder<static>|Expense whereCreatedAt($value)
 * @method static Builder<static>|Expense whereDeletedAt($value)
 * @method static Builder<static>|Expense whereDriverId($value)
 * @method static Builder<static>|Expense whereExpenseCategoryId($value)
 * @method static Builder<static>|Expense whereId($value)
 * @method static Builder<static>|Expense whereIsReimbursable($value)
 * @method static Builder<static>|Expense whereNotes($value)
 * @method static Builder<static>|Expense wherePaymentMethodId($value)
 * @method static Builder<static>|Expense whereReceiptDate($value)
 * @method static Builder<static>|Expense whereReceiptTypeId($value)
 * @method static Builder<static>|Expense whereUpdatedAt($value)
 * @method static Builder<static>|Expense whereVendorId($value)
 * @method static Builder<static>|Expense whereWorkOrderId($value)
 * @method static Builder<static>|Expense withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Expense withoutTrashed()
 * @mixin \Eloquent
 */
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
