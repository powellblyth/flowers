<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CupDirectWinner
 * @package App\Models
 * @property Show $show
 * @property int winning_category_id
 * @property Category winningCategory
 * @property int winning_entry_id
 * @property Entry winningEntry
 * @property int year
 */
class CupDirectWinner extends Model
{
    public function show(): BelongsTo
    {
        return $this->belongsTo(Entry::class);
    }

    public function winningCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'winning_category_id');
    }

    public function entrant(): BelongsTo
    {
        return $this->belongsTo(Entrant::class);
    }

    public function winningEntry(): BelongsTo
    {
        return $this->belongsTo(Entry::class, 'winning_entry_id');
    }
}
