<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\CupDirectWinner
 *
 * @property int $id
 * @property int $cup_id
 * @property int $year
 * @property int|null $show_id
 * @property int|null $winning_category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $winning_entry_id
 * @property-read \App\Models\Entrant $entrant
 * @property-read \App\Models\Entry|null $show
 * @property-read \App\Models\Category|null $winningCategory
 * @property-read \App\Models\Entry|null $winningEntry
 * @method static \Illuminate\Database\Eloquent\Builder|CupDirectWinner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CupDirectWinner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CupDirectWinner query()
 * @method static \Illuminate\Database\Eloquent\Builder|CupDirectWinner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CupDirectWinner whereCupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CupDirectWinner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CupDirectWinner whereShowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CupDirectWinner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CupDirectWinner whereWinningCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CupDirectWinner whereWinningEntryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CupDirectWinner whereYear($value)
 * @mixin \Eloquent
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
