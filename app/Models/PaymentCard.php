<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class PaymentCard
 *
 * @package App\Models
 * @mixin \Eloquent
 * @property int $id
 * @property string $stripe_id
 * @property int $user_id
 * @property string $brand
 * @property string $card_name
 * @property string $last4
 * @property string $funding
 * @property string $country
 * @property int $expiry_month
 * @property int $expiry_year
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|PaymentCard newModelQuery()
 * @method static Builder|PaymentCard newQuery()
 * @method static Builder|PaymentCard query()
 * @method static Builder|PaymentCard whereBrand($value)
 * @method static Builder|PaymentCard whereCardName($value)
 * @method static Builder|PaymentCard whereCountry($value)
 * @method static Builder|PaymentCard whereCreatedAt($value)
 * @method static Builder|PaymentCard whereExpiryMonth($value)
 * @method static Builder|PaymentCard whereExpiryYear($value)
 * @method static Builder|PaymentCard whereFunding($value)
 * @method static Builder|PaymentCard whereId($value)
 * @method static Builder|PaymentCard whereLast4($value)
 * @method static Builder|PaymentCard whereStripeId($value)
 * @method static Builder|PaymentCard whereUpdatedAt($value)
 * @method static Builder|PaymentCard whereUserId($value)
 * @property int $is_default
 * @property-read User|null $user
 * @method static Builder|PaymentCard whereIsDefault($value)
 */
class PaymentCard extends Model
{
    use HasFactory;

    public $attributes = [
    ];

    public $casts = [
        'is_default' => 'boolean',
    ];

    public $fillable = [
        'stripe_id',
    ];

    /****   Attributes   ****/

    /****   Scopes   ****/

    /****   Relations   ****/

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /****   Checks   ****/

    /****   Methods   ****/

    /****   Statics   ****/

    public function setFromStripe(\Laravel\Cashier\PaymentMethod $stripePaymentMethod)
    {
        $this->stripe_id = $stripePaymentMethod->id;
        $this->last4 = $stripePaymentMethod->card->last4;
        $this->brand = $stripePaymentMethod->card->brand;
        $this->card_name = $stripePaymentMethod->billing_details->name;
        $this->funding = $stripePaymentMethod->card->funding;
        $this->country = $stripePaymentMethod->card->country;
        $this->expiry_month = $stripePaymentMethod->card->exp_month;
        $this->expiry_year = $stripePaymentMethod->card->exp_year;

        return $this;
    }


    public static function getDummyCards(): array
    {
        return [
            json_decode('{"id":"pm_1L3p2iHJv0e8AgMdiMf7FOYr","card":{"brand":"dummy","exp_year":1976,"exp_month":11,"last4":9999},"billing_details":{"name":"Alice Abbot"}}'),
            json_decode('{"id":"pm_1L3oe7HJv0e8AgMdRO0sJi1P","card":{"brand":"card","exp_year":1977,"exp_month":5,"last4":6666},"billing_details":{"name":"Bob Brady"}}'),
        ];
    }
}
