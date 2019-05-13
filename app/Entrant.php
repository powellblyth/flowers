<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entrant extends Model {

    public function getUrl() {
        return '/entrants/' . $this->id;
    }

    public function getName(bool $printable=null):string {
        if ($printable){
            return $this->getPrintableName();
        }
        else {
            return trim($this->firstname . ' ' . $this->familyname);
        }
    }

    public function getPrintableName():string {
        return trim(substr($this->firstname, 0, 1) . ' ' . $this->familyname);
    }

    public function getAddress():string {
        $concatted = trim($this->address) . ', '
            . trim($this->address2) . ', ' . trim($this->addresstown);
        $deduped = str_replace(', , ', ', ',
            str_replace(', , ', ', ',
                $concatted));
        return trim(trim($deduped, ', ') . ' ' . trim($this->postcode), ', ');
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
