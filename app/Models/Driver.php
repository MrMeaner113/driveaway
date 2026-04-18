<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property string $license_number
 * @property string $license_class
 * @property int $issuing_jurisdiction_id
 * @property \Carbon\CarbonImmutable $license_expiry
 * @property bool $has_air_brakes
 * @property bool $has_passenger
 * @property bool $manual_shift
 * @property \Carbon\CarbonImmutable|null $medical_cert_expiry
 * @property \Carbon\CarbonImmutable|null $abstract_date
 * @property string|null $restrictions
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read \App\Models\Province|null $issuingJurisdiction
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereAbstractDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereHasAirBrakes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereHasPassenger($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereIssuingJurisdictionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereLicenseClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereLicenseExpiry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereLicenseNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereManualShift($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereMedicalCertExpiry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereRestrictions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver withoutTrashed()
 * @mixin \Eloquent
 */
class Driver extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'contact_id',
        'driver_status_id',
        'user_id',
        'license_number',
        'license_class',
        'issuing_jurisdiction_id',
        'license_expiry',
        'has_air_brakes',
        'has_passenger',
        'manual_shift',
        'medical_cert_expiry',
        'abstract_date',
        'restrictions',
    ];

    protected function casts(): array
    {
        return [
            'license_expiry'      => 'date',
            'medical_cert_expiry' => 'date',
            'abstract_date'       => 'date',
            'has_air_brakes'      => 'boolean',
            'has_passenger'       => 'boolean',
            'manual_shift'        => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function issuingJurisdiction(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'issuing_jurisdiction_id');
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(DriverStatus::class, 'driver_status_id');
    }
}
