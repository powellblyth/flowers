<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * @property string applies_to
 * @property string description
 * @property Carbon valid_from
 * @property Carbon valid_to
 * @property Carbon purchasable_from
 * @property Carbon purchasable_to
 * @property int price_gbp
 * @property string sku
 * @property string label
 */
class Membership extends Model
{
    public const APPLIES_TO_ENTRANT = 'entrant';
    public const APPLIES_TO_USER = 'user';

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
