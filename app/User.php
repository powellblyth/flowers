<?php

namespace App;

use App\Events\UserSaving;
use App\Observers\UserObserver;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    use Notifiable;

    const ADMIN_TYPE = 'admin';
    const DEFAULT_TYPE = 'default';

    protected $dispatchesEvents = [
        'saving' => UserSaving::class
    ];
    public function isAdmin() {
        return $this->type === self::ADMIN_TYPE;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'auth_token', 'password_reset_token',
        'address', 'address2', 'addresstown', 'postcode', 'retain_data_opt_in',
        'can_retain_data', 'email_opt_in', 'can_email', 'sms_opt_in', 'can_sms', 'sms_opt_in', 'can_post', 'post_opt_in',

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'auth_token', 'password_reset_token'
    ];

    public function getUrl() {
        return route('user.edit', $this);
    }

    public function getName(bool $printable = null): string {
        if ($printable) {
            return $this->getPrintableName();
        } else {
            return trim($this->firstname . ' ' . $this->lastname);
        }
    }

    public function getAddress(): string {
        $concatted = trim($this->address) . ', '
            . trim($this->address2) . ', ' . trim($this->addresstown);
        $deduped = str_replace(', , ', ', ',
            str_replace(', , ', ', ',
                $concatted));
        return trim(trim($deduped, ', ') . ' ' . trim($this->postcode), ', ');
    }

    /**
     * This creates a single entrant matching the user's data
     */
    public function makeDefaultEntrant() {
        $entrant = new Entrant();
        $entrant->firstname = $this->firstname;
        $entrant->familyname = $this->lastname;
        $entrant->can_retain_data = $this->can_retain_data;
        $entrant->can_sms = $this->can_sms;
        $entrant->can_email = $this->can_email;
        $entrant->can_post = $this->can_post;
        if ($entrant->save()) {
            $this->entrants()->save($entrant);
        }

    }

    public function getPrintableName(): string {
        return trim(substr($this->firstname, 0, 1) . ' ' . $this->lastname);
    }

    public function entrants(): \Illuminate\Database\Eloquent\Relations\hasMany {
        return $this->hasMany('App\Entrant');
    }

    public function familyMemberships(bool $current = true) {
        $memberships = $this->hasMany('App\Membership', 'user_id')->where('type', 'family');
        if ($current) {
            $memberships = $memberships->where('year_start', env('CURRENT_YEAR'));
        }
        return $memberships;
    }


}
