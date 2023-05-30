<?php

namespace App\Models;

use App\Traits\BelongsToShow;
use \Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class RafflePrize
 *
 * @package App\Models
 * @mixin \Eloquent
 * @property int $id
 * @property int $raffle_donor_id
 * @property int $show_id
 * @property int|null $contacted_by_id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $notes
 * @property bool $is_offered
 * @property int|null $winner_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $contactedBy
 * @property-read RaffleDonor|null $raffleDonor
 * @property-read Show|null $show
 * @property-read User|null $winner
 * @method static Builder|RafflePrize newModelQuery()
 * @method static Builder|RafflePrize newQuery()
 * @method static Builder|RafflePrize query()
 * @method static Builder|RafflePrize whereContactedById($value)
 * @method static Builder|RafflePrize whereCreatedAt($value)
 * @method static Builder|RafflePrize whereId($value)
 * @method static Builder|RafflePrize whereIsOffered($value)
 * @method static Builder|RafflePrize whereNotes($value)
 * @method static Builder|RafflePrize wherePrizeDescription($value)
 * @method static Builder|RafflePrize wherePrizeTitle($value)
 * @method static Builder|RafflePrize whereRaffleDonorId($value)
 * @method static Builder|RafflePrize whereS§howId($value)
 * @method static Builder|RafflePrize whereUpdatedAt($value)
 * @method static Builder|RafflePrize whereWinnerId($value)
 */
class RafflePrize extends Model
{
    use BelongsToShow;
    use HasFactory;

    public $attributes = [
        'is_offered' => true,
    ];

    public $casts = [
        'is_offered' => 'boolean',
    ];

    /****   Attributes   ****/

    /****   Scopes   ****/

    /****   Scopes   ****/
    public function scopeIsActive(Builder $query): Builder
    {
        return $query->where($this->getTable() . '.is_offered', true);
    }

    /****   Relations   ****/

    public function show(): BelongsTo
    {
        return $this->belongsTo(Show::class);
    }

    public function raffleDonor(): BelongsTo
    {
        return $this->belongsTo(RaffleDonor::class);
    }

    public function contactedBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function winner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /****   Checks   ****/

    /****   Methods   ****/

    /****   Statics   ****/
}
