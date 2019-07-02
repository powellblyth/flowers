<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MembershipPurchase extends Model {
    public function getNumber(): ?string {
        $membershipNumber = null;
        if ((int)$this->year == (int)config('app.year')) {
            switch ($this->type) {
                case 'family':
                    $membershipNumber = 'FM-' . str_pad((string)$this->id, 5, '0', STR_PAD_LEFT);
                    break;
                case 'individual':
                default:
                    $membershipNumber = 'SM-' . str_pad((string)$this->id, 5, '0', STR_PAD_LEFT);
                    break;
            }
        }
        return $membershipNumber;
    }

    public function user(): BelongsTo {
        return $this->belongsTo('App\User');
    }
    public function entrant(): BelongsTo {
        return $this->belongsTo('App\Entrant');
    }

}
