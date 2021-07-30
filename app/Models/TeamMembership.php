<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\TeamMembership
 *
 * @property int $id
 * @property int $entrant_id
 * @property int $team_id
 * @property int $show_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Entrant $entrant
 * @property-read \App\Models\Show $show
 * @property-read \App\Models\Team $team
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMembership newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMembership newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMembership query()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMembership whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMembership whereEntrantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMembership whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMembership whereShowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMembership whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMembership whereUpdatedAt($value)
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
