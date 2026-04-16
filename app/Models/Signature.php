<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $ulid
 * @property string $signable_type
 * @property int $signable_id
 * @property string $signer_name
 * @property string $signer_role
 * @property string $signature_data
 * @property \Carbon\CarbonImmutable $signed_at
 * @property string|null $ip_address
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read Model|\Eloquent $signable
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereSignableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereSignableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereSignatureData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereSignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereSignerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereSignerRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereUlid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
