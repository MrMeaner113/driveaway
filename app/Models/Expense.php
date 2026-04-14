<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'work_order_id',
        'driver_id',
        'expense_category_id',
        'vendor_id',
        'receipt_type_id',
        'payment_method_id',
        'amount',
        'receipt_date',
        'is_reimbursable',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'receipt_date'    => 'date',
            'is_reimbursable' => 'boolean',
        ];
    }

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function receiptType(): BelongsTo
    {
        return $this->belongsTo(ReceiptType::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
