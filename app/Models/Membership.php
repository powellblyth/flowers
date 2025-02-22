<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;


/**
 * App\Models\Membership
 *
 * @property int $id
 * @property string|null $sku
 * @property string|null $label
 * @property string|null $description
 * @property int|null $price_gbp
 * @property string|null $applies_to
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read Collection|MembershipPurchase[] $membershipsSold
 * @property-read int|null $memberships_sold_count
 * @method static Builder|Membership newModelQuery()
 * @method static Builder|Membership newQuery()
 * @method static Builder|Membership query()
 * @method static Builder|Membership whereAppliesTo($value)
 * @method static Builder|Membership whereCreatedAt($value)
 * @method static Builder|Membership whereDeletedAt($value)
 * @method static Builder|Membership whereDescription($value)
 * @method static Builder|Membership whereId($value)
 * @method static Builder|Membership whereLabel($value)
 * @method static Builder|Membership wherePriceGbp($value)
 * @method static Builder|Membership whereSku($value)
 * @method static Builder|Membership whereUpdatedAt($value)
 * @method static Builder|Membership whereValidFrom($value)
 * @method static Builder|Membership whereValidTo($value)
 * @property string|null $stripe_id
 * @property string|null $stripe_price
 * @property-read \App\Models\SubscriptionItem|null $subscriptionItem
 * @method static Builder|Membership whereStripeId($value)
 * @method static Builder|Membership whereStripePrice($value)
 * @property-read string $formatted_price
 * @mixin \Eloquent
 */
class Membership extends Model
{
    public final const APPLIES_TO_ENTRANT = 'entrant';
    public final const APPLIES_TO_USER = 'user';

    protected $casts = [
    ];

    protected $fillable = [
        'sku',
        'label',
        'description',
        'price_gbp',
        'applies_to',
    ];

    public function formattedPrice(): Attribute
    {
        return new Attribute(
            get: function ($value): string {
                return number_format($this->price_gbp / 100, 2);
            },
        );
    }

    public function subscriptionItem(): BelongsTo
    {
        return $this->belongsTo(SubscriptionItem::class);
    }

    //
    public function membershipsSold(): HasMany
    {
        return $this->hasMany(MembershipPurchase::class);
    }


    public function isEntrant(): bool
    {
        return $this->applies_to === Membership::APPLIES_TO_ENTRANT;
    }

    public static function getTypes(): array
    {
        return [
            Membership::APPLIES_TO_ENTRANT => 'Entrant',
            Membership::APPLIES_TO_USER => 'Family',
        ];
    }

    public static function getTypesWithLabels(): array
    {
        $entrantMembership = Membership::whereSku('SINGLE')->first();
        $familyMembership = Membership::whereSku('FAMILY')->first();
        return [
            Membership::APPLIES_TO_ENTRANT => $entrantMembership->label . ' £' . ($entrantMembership->price_gbp / 100),
            Membership::APPLIES_TO_USER => $familyMembership->label . ' £' . ($familyMembership->price_gbp / 100),
            //            Membership::APPLIES_TO_USER => 'Family',
        ];
    }

    /**
     * This method is a utility to determine the next appropriate renewal date
     * @return Carbon
     */
    public static function getRenewalDate(): Carbon
    {
        $renewalDate = new Carbon('first day of June ' . date('Y'));
        if ($renewalDate->isBefore(new Carbon('Tomorrow'))) {
            $renewalDate = new Carbon('first day of June ' . (((int) date('Y')) + 1));
        }
        return $renewalDate;
    }

    public static function getMembershipForType(string $type): Membership
    {
        return match ($type) {
            Membership::APPLIES_TO_ENTRANT => Membership::firstWhere('sku', 'SINGLE'),
            default => Membership::firstWhere('sku', 'FAMILY'),
        };
    }
}
