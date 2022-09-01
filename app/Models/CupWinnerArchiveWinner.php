<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * Class CupWinnerArchiveWinner
 *
 * @package App\Models
 * @mixin \Eloquent
 * @property int $id
 * @property int $cup_winner_archive_id
 * @property int $entrant_id
 * @property int|null $points
 * @property int|null $entry_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read CupWinnerArchive|null $cupWinnerArchive
 * @property-read Entrant|null $entrant
 * @property-read Entry|null $entry
 * @method static Builder|CupWinnerArchiveWinner newModelQuery()
 * @method static Builder|CupWinnerArchiveWinner newQuery()
 * @method static Builder|CupWinnerArchiveWinner query()
 * @method static Builder|CupWinnerArchiveWinner whereCreatedAt($value)
 * @method static Builder|CupWinnerArchiveWinner whereCupWinnerArchiveId($value)
 * @method static Builder|CupWinnerArchiveWinner whereEntrantId($value)
 * @method static Builder|CupWinnerArchiveWinner whereEntryId($value)
 * @method static Builder|CupWinnerArchiveWinner whereId($value)
 * @method static Builder|CupWinnerArchiveWinner wherePoints($value)
 * @method static Builder|CupWinnerArchiveWinner whereUpdatedAt($value)
 * @property int $sort_order
 * @method static Builder|CupWinnerArchiveWinner inOrder()
 * @method static Builder|CupWinnerArchiveWinner whereSortOrder($value)
 */
class CupWinnerArchiveWinner extends Model
{
    use HasFactory;

    public $attributes = [
    ];

    public $casts = [
        'points' => 'int',
    ];

    /****   Attributes   ****/
    public function placeLabel(): Attribute
    {
        // TODO this doesnt' match points i.e. joint first
        return new Attribute(
            get: function () {
                return match ($this->sort_order) {
                    1 => 'first',
                    2 => 'second',
                    3 => 'third',
                    4 => 'fourth',
                    5 => 'fifth',
                    6 => 'sixth',
                    default => $this->sort_order,
                };
            },
        );
    }

    /****   Scopes   ****/

    public function scopeInOrder(Builder $query): Builder
    {
        return $query->orderby('cup_winner_archive_winners.sort_order');
    }

    /****   Relations   ****/

    public function cupWinnerArchive(): BelongsTo
    {
        return $this->belongsTo(CupWinnerArchive::class);
    }

    public function entrant(): BelongsTo
    {
        return $this->belongsTo(Entrant::class);
    }

    public function entry(): BelongsTo
    {
        return $this->belongsTo(Entry::class);
    }

    /****   Checks   ****/

    /****   Methods   ****/

    /****   Statics   ****/

}
