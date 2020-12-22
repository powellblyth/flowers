<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CupDirectWinner
 * @package App\Models
 * @property int id
 */
class CupDirectWinner extends Model
{
    public function show(): BelongsTo
    {
        return $this->belongsTo(Entry::class);
    }
    //
}
