<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\CupDirectWinner
 *
 * @property int $id
 * @property int $cup_id
 * @property int $year
 * @property int|null $show_id
 * @property int|null $winning_category_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $winning_entry_id
 * @property-read Entrant $entrant
 * @property-read Entry|null $show
 * @property-read Category|null $winningCategory
 * @property-read Entry|null $winningEntry
 * @method static Builder|CupDirectWinner newModelQuery()
 * @method static Builder|CupDirectWinner newQuery()
 * @method static Builder|CupDirectWinner query()
 * @method static Builder|CupDirectWinner whereCreatedAt($value)
 * @method static Builder|CupDirectWinner whereCupId($value)
 * @method static Builder|CupDirectWinner whereId($value)
 * @method static Builder|CupDirectWinner whereShowId($value)
 * @method static Builder|CupDirectWinner whereUpdatedAt($value)
 * @method static Builder|CupDirectWinner whereWinningCategoryId($value)
 * @method static Builder|CupDirectWinner whereWinningEntryId($value)
 * @method static Builder|CupDirectWinner whereYear($value)
 * @mixin \Eloquent
 */
class CupDirectWinner extends Model
{
    public function scopeForShow(Builder $query, Show $show)
    {
        return $query->where('show_id', $show->id);
    }

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

    public function cup(): BelongsTo
    {
        return $this->belongsTo(Cup::class);
    }

    public function winningEntry(): BelongsTo
    {
        return $this->belongsTo(Entry::class, 'winning_entry_id');
    }
}
