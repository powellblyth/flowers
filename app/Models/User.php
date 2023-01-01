<?php

namespace App\Models;

use App\Events\UserSaving;
use App\Traits\Mergable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Laravel\Cashier\Billable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $email
 * @property string|null $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $first_name
 * @property string $last_name
 * @property string $status
 * @property string $type
 * @property string|null $address_1
 * @property string|null $address_2
 * @property string|null $address_town
 * @property string|null $postcode
 * @property bool|null $can_retain_data
 * @property Carbon|null $retain_data_opt_in
 * @property bool|null $can_email
 * @property Carbon|null $email_opt_in
 * @property int|null $can_phone
 * @property Carbon|null $phone_opt_in
 * @property bool|null $can_sms
 * @property Carbon|null $sms_opt_in
 * @property string|null $email_verified_at
 * @property bool $is_anonymised
 * @property bool|null $can_post
 * @property Carbon|null $post_opt_in
 * @property Carbon|null $post_opt_out
 * @property Carbon|null $sms_opt_out
 * @property Carbon|null $retain_data_opt_out
 * @property Carbon|null $phone_opt_out
 * @property Carbon|null $email_opt_out
 * @property string|null $telephone
 * @property string|null $stripe_id
 * @property string|null $card_brand
 * @property string|null $card_last_four
 * @property string|null $trial_ends_at
 * @property-read Collection|Entrant[] $entrants
 * @property-read int|null $entrants_count
 * @property-read Collection|MembershipPurchase[] $familyMemberships
 * @property-read int|null $family_memberships_count
 * @property-read string $full_name
 * @property-read Collection|MembershipPurchase[] $membershipPurchases
 * @property-read int|null $membership_purchases_count
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|Payment[] $payments
 * @property-read int|null $payments_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereAddress1($value)
 * @method static Builder|User whereAddress2($value)
 * @method static Builder|User whereAddressTown($value)
 * @method static Builder|User whereCanEmail($value)
 * @method static Builder|User whereCanPhone($value)
 * @method static Builder|User whereCanPost($value)
 * @method static Builder|User whereCanRetainData($value)
 * @method static Builder|User whereCanSms($value)
 * @method static Builder|User whereCardBrand($value)
 * @method static Builder|User whereCardLastFour($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailOptIn($value)
 * @method static Builder|User whereEmailOptOut($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereFirstName($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereIsAnonymised($value)
 * @method static Builder|User whereLastName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePhoneOptIn($value)
 * @method static Builder|User wherePhoneOptOut($value)
 * @method static Builder|User wherePostOptIn($value)
 * @method static Builder|User wherePostOptOut($value)
 * @method static Builder|User wherePostcode($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereRetainDataOptIn($value)
 * @method static Builder|User whereRetainDataOptOut($value)
 * @method static Builder|User whereSmsOptIn($value)
 * @method static Builder|User whereSmsOptOut($value)
 * @method static Builder|User whereStatus($value)
 * @method static Builder|User whereStripeId($value)
 * @method static Builder|User whereTelephone($value)
 * @method static Builder|User whereTrialEndsAt($value)
 * @method static Builder|User whereType($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read string $safe_email
 * @property string|null $pm_type
 * @property string|null $pm_last_four
 * @property-read Collection|\Laravel\Cashier\Subscription[] $subscriptions
 * @property-read int|null $subscriptions_count
 * @method static Builder|User wherePmLastFour($value)
 * @method static Builder|User wherePmType($value)
 * @property-read Collection|\App\Models\PaymentCard[] $paymentCards
 * @property-read int|null $payment_cards_count
 */
class User extends Authenticatable
{
    use Notifiable;
    use HasFactory;

    use Mergable;
    use Billable;

    final const TYPE_ADMIN = 'admin';
    final const TYPE_DEFAULT = 'default';

    final const STATUS_ACTIVE = 'active';
    final const STATUS_INACTIVE = 'inactive';
    final const STATUS_DELETED = 'deleted';

    protected $attributes = [
        'type' => User::TYPE_DEFAULT,
        'status' => User::STATUS_ACTIVE,
    ];

    protected $casts = [
        'retain_data_opt_in' => 'datetime',
        'retain_data_opt_out' => 'datetime',
        'email_opt_in' => 'datetime',
        'email_opt_out' => 'datetime',
        'sms_opt_in' => 'datetime',
        'sms_opt_out' => 'datetime',
        'phone_opt_in' => 'datetime',
        'phone_opt_out' => 'datetime',
        'post_opt_in' => 'datetime',
        'post_opt_out' => 'datetime',
        'can_retain_data' => 'bool',
        'can_email' => 'bool',
        'can_sms' => 'bool',
        'can_post' => 'bool',
        'is_anonymised' => 'bool',
    ];

    protected $dispatchesEvents = [
        'saving' => UserSaving::class
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'auth_token', 'password_reset_token',
        'telephone', 'address_1', 'address_2', 'address_town', 'postcode', 'retain_data_opt_in',
        'can_retain_data', 'email_opt_in', 'can_email', 'sms_opt_in', 'can_sms', 'sms_opt_in', 'can_post',
        'post_opt_in',

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'auth_token', 'password_reset_token'
    ];

    public function address(): Attribute
    {
        return new Attribute(
            get: function ($value): string {
                $words = new Collection([$this->address_1, $this->address_2, $this->address_town]);
                $address = implode(
                    ', ',
                    $words->reject(fn($value) => empty(trim($value)))
                        ->toArray()
                );
                return trim($address . ' ' . trim($this->postcode), ', ');
            }
        );
    }

    public function fullName(): Attribute
    {
        return new Attribute(
            get: fn($value) => trim($this->first_name . ' ' . $this->last_name)
        );
    }

    public function printableName(): Attribute
    {
        return new Attribute(
            get: fn($value) => trim(substr($this->first_name, 0, 1) . ' ' . $this->last_name)
        );
    }

    public function safeEmail(): Attribute
    {
        return new Attribute(
            get: function ($value) {
                if ('production' === App::environment()) {
                    return $this->email;
                }
                return Str::beforeLast($this->email, '@') . '@powellblyth.com';
            }
        );
    }

    public function entrants(): HasMany
    {
        return $this->hasMany(Entrant::class);
    }

    public function membershipPurchases(): HasMany
    {
        return $this->hasMany(MembershipPurchase::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function paymentCards(): HasMany
    {
        return $this->hasMany(PaymentCard::class);
    }

    public function isAdmin(): bool
    {
        return $this->type === self::TYPE_ADMIN;
    }

    /**
     * This creates a single entrant matching the user's data
     */
    public function createDefaultEntrant()
    {
        $entrant = new Entrant();
        $entrant->first_name = $this->first_name;
        $entrant->family_name = $this->last_name;
        $entrant->can_retain_data = $this->can_retain_data;
        if ($entrant->save()) {
            $this->entrants()->save($entrant);
        }
    }

    public function familyMemberships(): HasMany
    {
        return $this->hasMany(MembershipPurchase::class, 'user_id')->where('type', 'family');
    }

    public function teamMemberships($year = null): HasManyThrough
    {
        $year = $year ?? config('app.year');
        return $this->hasManyThrough(TeamMembership::class, TeamMembership::class);
    }

    public function routeNotificationForMail(): string
    {
        return $this->email;
    }

    public function getMemberNumber(): ?string
    {
        $membership = $this->membershipPurchases()
            ->where('end_date', '<', date('Y-m-d 11:39:39'))
            ->first();
        if ($membership instanceof MembershipPurchase) {
            return $membership->getNumber();
        } else {
            return null;
        }
    }

    public function anonymisePostcode(?string $postcode): ?string
    {
        $newPostcode = null;
        if (!empty($postcode)) {
            $oldPostcode = explode(' ', trim($postcode));
            $newPostcode = 2 == count($oldPostcode) ? $oldPostcode[0] . substr($oldPostcode[1], 0, 1) : substr($postcode, 0, 5);
        }
        return $newPostcode;
    }

    public function anonymise(): User
    {
        $this->email = $this->id . '@' . $this->id . 'phs-anonymised' . rand(0, 100000) . '.com';
        $this->is_anonymised = true;
        $this->first_name = 'Anonymised';
        $this->last_name = 'Anonymised';
        $this->telephone = null;
        $this->address_1 = null;
        $this->address_2 = null;
        $this->address_town = null;
        $this->retain_data_opt_in = null;
        $this->retain_data_opt_out = null;
        $this->email_opt_in = null;
        $this->email_opt_out = null;
        $this->can_email = false;
        $this->phone_opt_in = null;
        $this->phone_opt_out = null;
        $this->can_phone = false;
        $this->sms_opt_in = null;
        $this->sms_opt_out = null;
        $this->can_sms = false;
        $this->post_opt_in = null;
        $this->post_opt_out = null;
        $this->can_post = false;

        $this->postcode = $this->anonymisePostcode($this->postcode);
        $this->created_at = null;

        return $this;
    }

    public static function getAllStatuses(): array
    {
        return ['active' => 'Active', 'inactive' => 'Inactive', 'deleted' => 'Deleted'];
    }

    public static function getAllTypes(): array
    {
        return ['default' => 'Default', 'admin' => 'Admin'];
    }
}
