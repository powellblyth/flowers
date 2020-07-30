<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamMembership extends Model
{
    protected $fillable = [
        'entrant_id',
        'team_id',
        'show_id'
    ];
    public function entrant():BelongsTo
    {
        return $this-> belongsTo(Entrant::class);
    }
    public function team():BelongsTo
    {
        return $this-> belongsTo(Team::class);
    }
    public function show():BelongsTo
    {
        return $this->belongsTo(Show::class);
    }
    //
}