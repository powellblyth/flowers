<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamMembership extends Model
{
    public function user():BelongsTo
    {
        return $this-> belongsTo(User::class);
    }
    public function team():BelongsTo
    {
        return $this-> belongsTo(Team::class);
    }
    //
}
