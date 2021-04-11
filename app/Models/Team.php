<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Notifications\Notifiable;

//use Laravel\Cashier\Billable;

/**
 * @property int max_age
 * @property int min_age
 */
class Team extends Model
{
    use Notifiable;

    const STATUS_ACTIVE = 'active';

    protected $attributes = [
        'status' => 'active',
    ];

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class);
    }

//    public function entrants(): HasMany
//    {
//        return $this->hasMany(Entrant::class);
//    }

    public function entrants(): HasManyThrough
    {
        return $this->hasManyThrough(Entrant::class, TeamMembership::class);
    }

    public function entrantsForShow(Show $show): HasMany
    {
        return $this->teams()->where('show_id', $show->id)->where('');
    }
}
