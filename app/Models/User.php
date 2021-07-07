<?php

namespace App\Models;

use App\Events\UserSaving;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

//use Laravel\Cashier\Billable;

/**
 * @method static User create(array $array)
 * @method static User find(int $userId)
 * @method static Builder orderBy(string $column, ?string $direction = null)
 * @method static Builder where(string|array $column, ?string $valueOrComparator, ?string $value = null)
 * @method static User firstWhere(int $userId)
 * @method static User findOrFail(int $userId)
 * @method static User firstOrNew(int $userId)
 * @method static User firstOrCreate(array $array, array $array)
 * @property Collection entrants
 * @property string type
 * @property string firstname
 * @property string lastname
 * @property string telephone
 * @property string address
 * @property string address2
 * @property string addresstown
 * @property string postcode
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon post_opt_in
 * @property Carbon post_opt_out
 * @property Carbon sms_opt_out
 * @property Carbon sms_opt_in
 * @property Carbon retain_data_opt_out
 * @property Carbon retain_data_opt_in
 * @property Carbon phone_opt_out
 * @property Carbon phone_opt_in
 * @property Carbon email_opt_out
 * @property Carbon email_opt_in
 * @property int id
 * @property bool can_retain_data
 * @property bool is_anonymised
 * @property bool can_sms
 * @property bool can_phone
 * @property bool can_post
 * @property bool can_email
 * @property string email
 */
class User extends Authenticatable
{
    use Notifiable;
    use HasFactory;

    use Billable;

    const ADMIN_TYPE = 'admin';
    const DEFAULT_TYPE = 'default';

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
        'firstname', 'lastname', 'email', 'password', 'auth_token', 'password_reset_token',
        'telephone', 'address', 'address2', 'addresstown', 'postcode', 'retain_data_opt_in',
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

    public function entrants(): HasMany
    {
        return $this->hasMany(Entrant::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function membershipPurchases(): HasMany
    {
        return $this->hasMany(MembershipPurchase::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->getName();
    }

    public function isAdmin(): bool
    {
        return $this->type === self::ADMIN_TYPE;
    }


    /**
     * If we are not on production then return a sensible false string
     */
    public function getSafeEmail(): string
    {
        $email = $this->email;
        if ('production' !== env('APP_ENV')) {
            $email = str_replace(substr($email, strpos($email, '@')), '@powellblyth.com', $email);
        }
        return $email;
    }

    public function getName(bool $printable = null): string
    {
        if ($printable) {
            return $this->getPrintableName();
        } else {
            return trim($this->firstname . ' ' . $this->lastname);
        }
    }

    public function getAddress(): string
    {
        $concatted = trim($this->address) . ', '
                     . trim($this->address2) . ', ' . trim($this->addresstown);
        $deduped = str_replace(
            ', , ',
            ', ',
            str_replace(', , ', ', ', $concatted)
        );
        return trim(trim($deduped, ', ') . ' ' . trim($this->postcode), ', ');
    }

    /**
     * This creates a single entrant matching the user's data
     */
    public function makeDefaultEntrant()
    {
        $entrant = new Entrant();
        $entrant->firstname = $this->firstname;
        $entrant->familyname = $this->lastname;
        $entrant->can_retain_data = $this->can_retain_data;
        if ($entrant->save()) {
            $this->entrants()->save($entrant);
        }
    }

    public function getPrintableName(): string
    {
        return trim(substr($this->firstname, 0, 1) . ' ' . $this->lastname);
    }

    public function familyMemberships(): HasMany
    {
        return $memberships = $this->hasMany(MembershipPurchase::class, 'user_id')->where('type', 'family');
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
        if (!is_null($postcode) && !empty($postcode)) {
            $oldPostcode = explode(' ', trim($postcode));
            if (2 == count($oldPostcode)) {
                $newPostcode = $oldPostcode[0] . substr($oldPostcode[1], 0, 1);
            } else {
                $newPostcode = substr($postcode, 0, 5);
            }
        }
        return $newPostcode;
    }

    public function anonymise(): User
    {
        $this->email = $this->id . '@' . $this->id . 'phs-anonymised' . rand(0, 100000) . '.com';
        $this->is_anonymised = true;
        $this->firstname = 'Anonymised';
        $this->lastname = 'Anonymised';
        $this->telephone = null;
        $this->address = null;
        $this->address2 = null;
        $this->addresstown = null;
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
}
