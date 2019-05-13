<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const ADMIN_TYPE = 'admin';
    const DEFAULT_TYPE = 'default';
    public function isAdmin()    {
        return false;$this->type === self::ADMIN_TYPE;
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password','auth_token','password_reset_token',
        'address', 'address2', 'addresstown', 'postcode', 'retain_data_opt_in',
        'can_retain_data', 'email_opt_in', 'can_email', 'sms_opt_in', 'can_sms'

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','auth_token','password_reset_token'
    ];

    public function entrants(): \Illuminate\Database\Eloquent\Relations\hasMany {
        return $this->hasMany('App\Entrant');
    }
    public function getAddress():string {
        $concatted = trim($this->address) . ', '
            . trim($this->address2) . ', ' . trim($this->addresstown);
        $deduped = str_replace(', , ', ', ',
            str_replace(', , ', ', ',
                $concatted));
        return trim(trim($deduped, ', ') . ' ' . trim($this->postcode), ', ');
    }
}
