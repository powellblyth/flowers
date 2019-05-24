<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entrant extends Model {

    public function getUrl() {
        return route('entrants.show', $this);
    }

    public function getName(bool $printable=null):string {
        if ($printable){
            return $this->getPrintableName();
        }
        else {
            return trim($this->firstname . ' ' . $this->familyname);
        }
    }

    /**
     * Simple way to get an entrant number
     * @return string
     */
    public function getEntrantNumber():string{
        return 'E-'. str_pad((string)$this->id,'5', '0',STR_PAD_LEFT);
    }
    public function getPrintableName():string {
        return trim(substr($this->firstname, 0, 1) . ' ' . $this->familyname);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\belongsTo {
        return $this->belongsTo('App\User');
    }
    public function entries(): \Illuminate\Database\Eloquent\Relations\hasMany {
        return $this->hasMany('App\Entry');
    }
    public function payments(): \Illuminate\Database\Eloquent\Relations\hasMany {
        return $this->hasMany('App\Payment');
    }
    public function membershipPurchases(): \Illuminate\Database\Eloquent\Relations\hasMany {
        return $this->hasMany('App\MembershipPurchase');
    }
}
