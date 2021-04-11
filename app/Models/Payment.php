<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Payment
 * @property int amount
 * @property string source
 * @property int entrant_id
 * @property Entrant entrant
 * @property int user_id
 * @property User user
 * @property int year
 * @package App\Models
 */
class Payment extends Model
{
    public function show(): BelongsTo
    {
        return $this->belongsTo(Entry::class);
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
