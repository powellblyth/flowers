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
        'firstname', 'lastname', 'email', 'password','auth_token','password_reset_token'
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
}
