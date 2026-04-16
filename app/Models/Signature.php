<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

class Signature extends Model
{
    protected $fillable = [
        'ulid',
        'signable_type',
        'signable_id',
        'signer_name',
        'signer_role',
        'signature_data',
        'signed_at',
        'ip_address',
    ];

    protected function casts(): array
    {
        return [
            'signed_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->ulid)) {
                $model->ulid = (string) Str::ulid();
            }
        });
    }

    public function signable(): MorphTo
    {
        return $this->morphTo();
    }
}
