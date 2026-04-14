<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'phone_ext',
        'mobile',
        'contact_type_id',
        'contact_status_id',
        'preferred_contact_method_id',
        'organization_id',
        'notes',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function contactType(): BelongsTo
    {
        return $this->belongsTo(ContactType::class);
    }

    public function contactStatus(): BelongsTo
    {
        return $this->belongsTo(ContactStatus::class);
    }

    public function preferredContactMethod(): BelongsTo
    {
        return $this->belongsTo(PreferredContactMethod::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }
}
