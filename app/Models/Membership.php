<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * App\Models\Membership
 *
 * @property int $id
 * @property string|null $sku
 * @property string|null $label
 * @property string|null $description
 * @property int|null $price_gbp
 * @property string|null $applies_to
 * @property \Illuminate\Support\Carbon|null $purchasable_from
 * @property \Illuminate\Support\Carbon|null $purchasable_to
 * @property \Illuminate\Support\Carbon|null $valid_from
 * @property \Illuminate\Support\Carbon|null $valid_to
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MembershipPurchase[] $membershipsSold
 * @property-read int|null $memberships_sold_count
 * @method static \Illuminate\Database\Eloquent\Builder|Membership newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Membership newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Membership query()
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereAppliesTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership wherePriceGbp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership wherePurchasableFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership wherePurchasableTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereValidFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereValidTo($value)
 * @mixin \Eloquent
 */
class Membership extends Model
{
    public final const APPLIES_TO_ENTRANT = 'entrant';
    public final const APPLIES_TO_USER = 'user';

    protected $casts = [
        'purchasable_from' => 'datetime',
        'purchasable_to' => 'datetime',
        'valid_from' => 'datetime',
        'valid_to' => 'datetime',
    ];

    protected $fillable = [
        'sku',
        'label',
        'description',
        'price_gbp',
        'applies_to',
        'purchasable_from',
        'purchasable_to',
        'valid_from',
        'valid_to'
    ];

    //
    public function membershipsSold(): HasMany
    {
        return $this->hasMany(MembershipPurchase::class);
    }


    public function isEntrant(): bool
    {
        return $this->applies_to === Membership::APPLIES_TO_ENTRANT;
    }
}
