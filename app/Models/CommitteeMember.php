<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CommitteeMember
 *
 * @package App\Models
 * @mixin \Eloquent
 * @property-read string $address
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Entrant[] $entrants
 * @property-read int|null $entrants_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MembershipPurchase[] $familyMemberships
 * @property-read int|null $family_memberships_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MembershipPurchase[] $membershipPurchases
 * @property-read int|null $membership_purchases_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PaymentCard[] $paymentCards
 * @property-read int|null $payment_cards_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Payment[] $payments
 * @property-read int|null $payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Cashier\Subscription[] $subscriptions
 * @property-read int|null $subscriptions_count
 * @method static \Illuminate\Database\Eloquent\Builder|CommitteeMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommitteeMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommitteeMember query()
 */
class CommitteeMember extends User
{

}
