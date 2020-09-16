<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Notifications\Notifiable;

//use Laravel\Cashier\Billable;

class Team extends Model
{
    use Notifiable;

//    use Billable;

    const STATUS_ACTIVE = 'active';

    protected $attributes = [
        'status' => 'active',
    ];

    public function getUrl(): string
    {
        return route('teams.show', $this);
    }

    public function team_memberships(): HasMany
    {
        return $this->hasMany(TeamMembership::class);
    }

//    public function entrants(): HasMany
//    {
//        return $this->hasMany(Entrant::class);
//    }

    public function entrants2(): HasManyThrough
    {
        return $this->hasManyThrough(Entrant::class, TeamMembership::class);
    }

    public function entrantsForShow(Show $show):HasMany
    {
        return $this->team_memberships()->where('show_id', $show->id)->where('');
    }
}
