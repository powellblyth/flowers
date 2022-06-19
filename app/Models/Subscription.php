<?php

namespace App\Models;

use Database\Factories\SubscriptionFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * Class Subscriptions
 *
 * @package App\Models
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $stripe_id
 * @property string $stripe_status
 * @property string|null $stripe_price
 * @property int|null $quantity
 * @property string|null $trial_ends_at
 * @property string|null $ends_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static SubscriptionFactory factory(...$parameters)
 * @method static Builder|Subscription newModelQuery()
 * @method static Builder|Subscription newQuery()
 * @method static Builder|Subscription query()
 * @method static Builder|Subscription whereCreatedAt($value)
 * @method static Builder|Subscription whereEndsAt($value)
 * @method static Builder|Subscription whereId($value)
 * @method static Builder|Subscription whereName($value)
 * @method static Builder|Subscription whereQuantity($value)
 * @method static Builder|Subscription whereStripeId($value)
 * @method static Builder|Subscription whereStripePrice($value)
 * @method static Builder|Subscription whereStripeStatus($value)
 * @method static Builder|Subscription whereTrialEndsAt($value)
 * @method static Builder|Subscription whereUpdatedAt($value)
 * @method static Builder|Subscription whereUserId($value)
 */
class Subscription extends Model
{
    use HasFactory;

    public $attributes = [
    ];

    public $casts = [
    ];

    /****   Attributes   ****/

    /****   Scopes   ****/

    /****   Relations   ****/

    public function membership(): ?Membership
    {
        return Membership::where('name', $this->stripe_id)
            //->where('price_id', $this->stripe_price)
            ->first();
    }

    /****   Checks   ****/

    /****   Methods   ****/

    /****   Statics   ****/

    public static function getDummyCards(): array
    {
        return [
            json_decode('{"id":"pm_1L3p2iHJv0e8AgMdiMf7FOYr","card":{"brand":"dummy","exp_year":1976,"exp_month":11,"last4":9999},"billing_details":{"name":"Alice Abbot"}}'),
            json_decode('{"id":"pm_1L3oe7HJv0e8AgMdRO0sJi1P","card":{"brand":"card","exp_year":1977,"exp_month":5,"last4":6666},"billing_details":{"name":"Bob Brady"}}'),
        ];
    }

}
