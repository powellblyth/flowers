<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MembershipPurchase extends Model
{
    public function getNumber(): ?string {
        $membershipNumber = null;
        if ((int)$this->year == (int)config('app.year')) {
            switch ($this->type) {
                case 'family':
                    $membershipNumber = 'FM-' . str_pad((string)$this->id, '5', '0', STR_PAD_LEFT);
                    break;
                case 'individual':
                default:
                    $membershipNumber = 'SM-' . str_pad((string)$this->id, '5', '0', STR_PAD_LEFT);
                    break;
            }
        }
        return $membershipNumber;
    }

}
