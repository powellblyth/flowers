<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static orderBy(string $string)
 */
class Membership extends Model
{
    const APPLIES_TO_ENTRANT = 'entrant';
    const APPLIES_TO_USER    = 'user';
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
        return $this->applies_to === self::APPLIES_TO_ENTRANT;
    }
}
