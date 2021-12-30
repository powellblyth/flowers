<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\TeamMembership
 *
 * @property int $id
 * @property int $entrant_id
 * @property int $team_id
 * @property int $show_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Entrant $entrant
 * @property-read Show $show
 * @property-read Team $team
 * @method static Builder|TeamMembership newModelQuery()
 * @method static Builder|TeamMembership newQuery()
 * @method static Builder|TeamMembership query()
 * @method static Builder|TeamMembership whereCreatedAt($value)
 * @method static Builder|TeamMembership whereEntrantId($value)
 * @method static Builder|TeamMembership whereId($value)
 * @method static Builder|TeamMembership whereShowId($value)
 * @method static Builder|TeamMembership whereTeamId($value)
 * @method static Builder|TeamMembership whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TeamMembership extends Model
{
    protected $fillable = [
        'entrant_id',
        'team_id',
        'show_id'
    ];

    public function entrant(): BelongsTo
    {
        return $this->belongsTo(Entrant::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function show(): BelongsTo
    {
        return $this->belongsTo(Show::class);
    }
}
