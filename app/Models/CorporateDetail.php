<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CorporateDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'contact_id',
        'company_name',
        'legal_name',
        'primary_contact_title',
        'phone_extension',
        'website',
        'billing_contact_name',
        'billing_email',
        'accounts_payable_email',
        'payment_terms',
        'hst_number',
        'special_instructions',
    ];

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
}
