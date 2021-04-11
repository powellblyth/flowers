<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class TeamMembership
 * @package App\Models
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
