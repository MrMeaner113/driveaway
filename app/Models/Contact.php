<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use App\Models\ContactCategory;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $phone_ext
 * @property string|null $mobile
 * @property int $contact_type_id
 * @property int $contact_status_id
 * @property int|null $preferred_contact_method_id
 * @property int|null $organization_id
 * @property string|null $notes
 * @property bool $is_active
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Address> $addresses
 * @property-read int|null $addresses_count
 * @property-read \App\Models\ContactStatus|null $contactStatus
 * @property-read \App\Models\ContactType|null $contactType
 * @property-read \App\Models\Organization|null $organization
 * @property-read \App\Models\PreferredContactMethod|null $preferredContactMethod
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereContactStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereContactTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact wherePhoneExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact wherePreferredContactMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact withoutTrashed()
 * @mixin \Eloquent
 */
class Contact extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'nickname',
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
        'staff_position_id',
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

    public function position(): BelongsTo
    {
        return $this->belongsTo(StaffPosition::class, 'staff_position_id');
    }

    public function driverProfile(): HasOne
    {
        return $this->hasOne(Driver::class);
    }

    public function corporateProfile(): HasOne
    {
        return $this->hasOne(CorporateDetail::class);
    }

    public function getFullNameAttribute(): string
    {
        if ($this->nickname) {
            return "{$this->first_name} ({$this->nickname}) {$this->last_name}";
        }
        return "{$this->first_name} {$this->last_name}";
    }

    public function getContactCategoryAttribute(): ?ContactCategory
    {
        return $this->contactType?->category;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOfType(Builder $query, int $typeId): Builder
    {
        return $query->where('contact_type_id', $typeId);
    }

    public function scopeOfCategory(Builder $query, string $categorySlug): Builder
    {
        return $query->whereHas('contactType', fn ($q) =>
            $q->whereHas('category', fn ($q2) => $q2->where('slug', $categorySlug))
        );
    }
}
