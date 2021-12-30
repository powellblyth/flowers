<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Payment
 *
 * @property int $id
 * @property int|null $entrant_id
 * @property string $amount
 * @property string $source
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $year
 * @property int|null $show_id
 * @property int|null $user_id
 * @property-read Entrant|null $entrant
 * @property-read Entry|null $show
 * @property-read User|null $user
 * @method static Builder|Payment newModelQuery()
 * @method static Builder|Payment newQuery()
 * @method static Builder|Payment query()
 * @method static Builder|Payment whereAmount($value)
 * @method static Builder|Payment whereCreatedAt($value)
 * @method static Builder|Payment whereEntrantId($value)
 * @method static Builder|Payment whereId($value)
 * @method static Builder|Payment whereShowId($value)
 * @method static Builder|Payment whereSource($value)
 * @method static Builder|Payment whereUpdatedAt($value)
 * @method static Builder|Payment whereUserId($value)
 * @method static Builder|Payment whereYear($value)
 * @mixin \Eloquent
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
