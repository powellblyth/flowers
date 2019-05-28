<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entrant extends Model {

    public function getUrl() {
        return route('entrants.show', $this);
    }

    public function getName(bool $printable = null): string {
        if ($printable) {
            return $this->getPrintableName();
        } else {
            return trim($this->firstname . ' ' . $this->familyname);
        }
    }

    /**
     * Simple way to get an entrant number
     * @return string
     */
    public function getEntrantNumber(): string {
        return 'E-' . str_pad((string)$this->id, '5', '0', STR_PAD_LEFT);
    }

    public function getPrintableName(): string {
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

    public function individualMemberships() {
        return $this->hasMany('\App\Membership', 'entrant_id');
    }

    public function familyMembership():?Membership {
        if ($this->user instanceof User) {
            return $this->user->familyMemberships()->first();
        }else{
            return null;
        }
    }

    public function getCurrentMembership(): ?Membership {
        $membership = $this->individualMemberships()->where('year_start', env('CURRENT_YEAR'))
            ->where('type', 'individual')
            ->first();
//        var_dump(get_class($membership));
//        die('here');
        if (!$membership instanceof Membership) {
//            die('not a member');
            $membership = $this->familyMembership();
        }
        return $membership;
    }

    public function isAMember(): bool {
        return $this->individualMemberships->count() > 0 || $this->familyMembership()->count() > 0;
    }

    public function getMemberNumber() {
        $membership = $this->getCurrentMembership();
            if ($membership instanceof \App\Membership) {
            return $membership->getNumber();
        } else {
            return null;
        }
    }
}
