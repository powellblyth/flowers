<?php

namespace App\Models;

use App\Traits\BelongsToShow;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\CupWinnerArchive
 *
 * @property int $id
 * @property int $cup_id
 * @property int $show_id
 * @property int|null $cup_winner_entrant_id
 * @property int|null $cup_winner_points
 * @property int|null $entry_id
 * @property int|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Cup|null $cup
 * @property-read Entrant|null $cupWinner
 * @property-read Entry|null $entry
 * @property-read Show|null $show
 * @method static Builder|CupWinnerArchive forShow(Show $show)
 * @method static Builder|CupWinnerArchive newModelQuery()
 * @method static Builder|CupWinnerArchive newQuery()
 * @method static Builder|CupWinnerArchive query()
 * @method static Builder|CupWinnerArchive whereCreatedAt($value)
 * @method static Builder|CupWinnerArchive whereCreatedBy($value)
 * @method static Builder|CupWinnerArchive whereCupId($value)
 * @method static Builder|CupWinnerArchive whereEntryId($value)
 * @method static Builder|CupWinnerArchive whereId($value)
 * @method static Builder|CupWinnerArchive whereShowId($value)
 * @method static Builder|CupWinnerArchive whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CupWinnerArchiveWinner[] $winners
 * @property-read int|null $winners_count
 * @method static Builder|CupWinnerArchive whereCupWinnerEntrantId($value)
 * @method static Builder|CupWinnerArchive whereCupWinnerPoints($value)
 */
class CupWinnerArchive extends Model
{
    use HasFactory;
    use BelongsToShow;

    public $attributes = [
    ];

    public $casts = [
    ];

    public $fillable = [
        'show_id',
        'cup_id',
    ];

    /****   Attributes   ****/

    public function winners(): HasMany
    {
        return $this->hasMany(CupWinnerArchiveWinner::class)->inOrder();
    }

    /****   Scopes   ****/

    /****   Relations   ****/

    public function cupWinner(): BelongsTo
    {
        return $this->belongsTo(Entrant::class, 'cup_winner_entrant_id');
    }

    public function entry(): BelongsTo
    {
        return $this->belongsTo(Entry::class);
    }

    public function cup(): BelongsTo
    {
        return $this->belongsTo(Cup::class);
    }

    /****   Checks   ****/

    /****   Methods   ****/

    /****   Statics   ****/

}
