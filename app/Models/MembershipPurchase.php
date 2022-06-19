<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\MembershipPurchase
 *
 * @property int $id
 * @property int|null $entrant_id
 * @property int $amount
 * @property string $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $year
 * @property int|null $user_id
 * @property string|null $number
 * @property Carbon|null $start_date
 * @property Carbon|null $end_date
 * @property int|null $membership_id
 * @property-read Entrant|null $entrant
 * @property-read Membership|null $membership
 * @property-read User|null $user
 * @method static Builder|MembershipPurchase newModelQuery()
 * @method static Builder|MembershipPurchase newQuery()
 * @method static Builder|MembershipPurchase query()
 * @method static Builder|MembershipPurchase whereAmount($value)
 * @method static Builder|MembershipPurchase whereCreatedAt($value)
 * @method static Builder|MembershipPurchase whereEndDate($value)
 * @method static Builder|MembershipPurchase whereEntrantId($value)
 * @method static Builder|MembershipPurchase whereId($value)
 * @method static Builder|MembershipPurchase whereMembershipId($value)
 * @method static Builder|MembershipPurchase whereNumber($value)
 * @method static Builder|MembershipPurchase whereStartDate($value)
 * @method static Builder|MembershipPurchase whereType($value)
 * @method static Builder|MembershipPurchase whereUpdatedAt($value)
 * @method static Builder|MembershipPurchase whereUserId($value)
 * @method static Builder|MembershipPurchase whereYear($value)
 * @mixin \Eloquent
 */
class MembershipPurchase extends Model
{
    final const TYPE_FAMILY = 'family';
    final const TYPE_INDIVIDUAL = 'individual';
    protected $fillable = [
        'entrant_id', 'type', 'year', 'user_id', 'number',
    ];
    public $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function getNumber(): ?string
    {
        $membershipNumber = null;
        if (empty($this->number)) {
            $membershipNumber = match ($this->type) {
                self::TYPE_FAMILY => 'FM-' . str_pad((string) $this->id, 5, '0', STR_PAD_LEFT),
                default => 'SM-' . str_pad((string) $this->id, 5, '0', STR_PAD_LEFT),
            };
        }
        return $membershipNumber;
    }

    public function isNotExpired(): bool
    {
        return (int) $this->year == (int) config('app.year');
    }

    public function scopeActive(BuilderContract $query): BuilderContract
    {
        return $query->where('end_date', '<=', Carbon::today()->toDateString());
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function entrant(): BelongsTo
    {
        return $this->belongsTo(Entrant::class);
    }

    public function membership(): BelongsTo
    {
        return $this->belongsTo(Membership::class);
    }
}
