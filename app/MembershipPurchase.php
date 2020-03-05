<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MembershipPurchase extends Model
{
    protected $fillable = [
        'entrant_id', 'type', 'year', 'user_id', 'number',

    ];

    public function getNumber(): ?string
    {
        $membershipNumber = null;
        if ( !empty($this->number)) {
            $membershipNumber = $this->number;
        } else {
            switch ($this->type) {
                case 'family':
                    $membershipNumber = 'FM-'.str_pad((string) $this->id, 5, '0', STR_PAD_LEFT);
                    break;
                case 'individual':
                default:
                    $membershipNumber = 'SM-'.str_pad((string) $this->id, 5, '0', STR_PAD_LEFT);
                    break;
            }
        }
        return $membershipNumber;
    }

    public function isNotExpired(): bool
    {
        return (int) $this->year == (int) config('app.year');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function entrant(): BelongsTo
    {
        return $this->belongsTo(Entrant::class);
    }

}
