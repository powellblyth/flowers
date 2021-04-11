<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class MembershipPurchase
 * @package App\Models
 * @property int year
 * @property string type
 * @property int entrant_id
 * @property int amount
 * @property string number
 * @property int user_id
 * @property Carbon start_date
 * @property Carbon end_date
 */
class MembershipPurchase extends Model
{
    const TYPE_FAMILY = 'family';
    const TYPE_INDIVIDUAL = 'individual';
    protected $fillable = [
        'entrant_id', 'type', 'year', 'user_id', 'number',
    ];
    public $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
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
