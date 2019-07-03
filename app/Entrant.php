<?php

namespace App;

use App\Events\EntrantSaving;
use App\Observers\EntrantObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class Entrant extends Model {
    use Notifiable;
    use Billable;

    protected $dispatchesEvents = [
        'saving' => EntrantSaving::class
    ];

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
        return 'E-' . str_pad((string)$this->id, 4, '0', STR_PAD_LEFT);
    }

    public function getPrintableName(): string {
        return trim(substr($this->firstname, 0, 1) . ' ' . $this->familyname);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo('App\User');
    }

    public function entries(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany('App\Entry');
    }

    public function payments(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany('App\Payment');
    }

    public function membershipPurchases(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany('App\MembershipPurchase');
    }

    public function individualMemberships() {
        return $this->hasMany('\App\MembershipPurchase', 'entrant_id');
    }

    public function familyMembership(): ?MembershipPurchase {
        if ($this->user instanceof User) {
            return $this->user->familyMemberships()->first();
        } else {
            return null;
        }
    }

    public function getCurrentMembership(): ?MembershipPurchase {
        $membership = $this->individualMemberships()->where('year', config('app.year'))
            ->where('type', 'individual')
            ->first();
//        var_dump(get_class($membership));
//        die('here');
        if (!$membership instanceof MembershipPurchase) {
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
        if ($membership instanceof \App\MembershipPurchase) {
            return $membership->getNumber();
        } else {
            return null;
        }
    }

//    public function
}
