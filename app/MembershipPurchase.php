<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MembershipPurchase extends Model
{
    const TYPE_FAMILY     = 'family';
    const TYPE_INDIVIDUAL = 'individual';
    protected $fillable = [
        'entrant_id', 'type', 'year', 'user_id', 'number',

    ];

    public function getNumber(): ?string
    {
        $membershipNumber = null;
        if (!empty($this->number)) {
            $membershipNumber = $this->number;
        } else {
            switch ($this->type) {
                case self::TYPE_FAMILY:
                    $membershipNumber = 'FM-' . str_pad((string) $this->id, 5, '0', STR_PAD_LEFT);
                    break;
                case self::TYPE_INDIVIDUAL:
                default:
                    $membershipNumber = 'SM-' . str_pad((string) $this->id, 5, '0', STR_PAD_LEFT);
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

    public function membership(): BelongsTo
    {
        return $this->belongsTo(Membership::class);
    }

}
