<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $invoice_id
 * @property string $description
 * @property numeric $quantity
 * @property int $unit_price
 * @property int $amount
 * @property int $sort_order
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Invoice|null $invoice
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLineItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLineItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLineItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLineItem whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLineItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLineItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLineItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLineItem whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLineItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLineItem whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLineItem whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLineItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InvoiceLineItem extends Model
{
    protected $fillable = [
        'invoice_id',
        'description',
        'quantity',
        'unit_price',
        'amount',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
        ];
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
