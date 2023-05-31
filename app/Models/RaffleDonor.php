<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Class RaffleDonor
 *
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property string|null $telephone
 * @property string|null $website
 * @property string|null $image
 * @property string|null $email
 * @property string|null $notes
 * @property string $description
 * @property bool $should_contact_again
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|RafflePrize[] $rafflePrizes
 * @property-read int|null $raffle_prizes_count
 * @method static Builder|RaffleDonor newModelQuery()
 * @method static Builder|RaffleDonor newQuery()
 * @method static Builder|RaffleDonor query()
 * @method static Builder|RaffleDonor whereCreatedAt($value)
 * @method static Builder|RaffleDonor whereDescription($value)
 * @method static Builder|RaffleDonor whereEmail($value)
 * @method static Builder|RaffleDonor whereId($value)
 * @method static Builder|RaffleDonor whereImage($value)
 * @method static Builder|RaffleDonor whereName($value)
 * @method static Builder|RaffleDonor whereNotes($value)
 * @method static Builder|RaffleDonor whereShouldContactAgain($value)
 * @method static Builder|RaffleDonor whereTelephone($value)
 * @method static Builder|RaffleDonor whereUpdatedAt($value)
 * @method static Builder|RaffleDonor whereWebsite($value)
 * @mixin \Eloquent
 */
class RaffleDonor extends Model
{
    use HasFactory;

    public $attributes = [
    ];

    public $casts = [
        'should_contact_again' => 'boolean',
    ];

    public function rafflePrizes(): HasMany
    {
        return $this->hasMany(RafflePrize::class);
    }

    /****   Checks   ****/

    /****   Methods   ****/

    /****   Statics   ****/

}
