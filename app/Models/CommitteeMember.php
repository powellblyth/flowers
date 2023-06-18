<?php

namespace App\Models;

use App\Models\Scopes\CommitteeMemberScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\DatabaseNotificationCollection;

/**
 * Class CommitteeMember
 *
 * @package App\Models
 * @property-read string $address
 * @property-read Collection|Entrant[] $entrants
 * @property-read int|null $entrants_count
 * @property-read Collection|MembershipPurchase[] $familyMemberships
 * @property-read int|null $family_memberships_count
 * @property-read Collection|MembershipPurchase[] $membershipPurchases
 * @property-read int|null $membership_purchases_count
 * @property-read DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|PaymentCard[] $paymentCards
 * @property-read int|null $payment_cards_count
 * @property-read Collection|Payment[] $payments
 * @property-read int|null $payments_count
 * @property-read Collection|\Laravel\Cashier\Subscription[] $subscriptions
 * @property-read int|null $subscriptions_count
 * @method static Builder|CommitteeMember newModelQuery()
 * @method static Builder|CommitteeMember newQuery()
 * @method static Builder|CommitteeMember query()
 * @mixin \Eloquent
 */
class CommitteeMember extends User
{
    protected $table = 'users';

    /**
     * Get the default foreign key name for the model.
     *
     * @return string
     */
    public function getForeignKey()
    {
        return 'user_'.$this->primaryKey;
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new CommitteeMemberScope());
    }
}
