<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FuelExpense extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'work_order_id',
        'driver_id',
        'fuel_vendor_id',
        'fuel_type_id',
        'fuel_unit_id',
        'quantity',
        'amount',
        'receipt_date',
        'receipt_type_id',
        'payment_method_id',
        'cra_t2125_id',
        'is_reimbursable',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'receipt_date'    => 'date',
            'quantity'        => 'decimal:3',
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

    public function fuelVendor(): BelongsTo
    {
        return $this->belongsTo(FuelVendor::class);
    }

    public function fuelType(): BelongsTo
    {
        return $this->belongsTo(FuelType::class);
    }

    public function fuelUnit(): BelongsTo
    {
        return $this->belongsTo(FuelUnit::class);
    }

    public function receiptType(): BelongsTo
    {
        return $this->belongsTo(ReceiptType::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function craLine(): BelongsTo
    {
        return $this->belongsTo(CraT2125Line::class, 'cra_t2125_id');
    }
}
