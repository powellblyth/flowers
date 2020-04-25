<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function getUrl()
    {
        return route('teams.show', $this);
    }

    public function entrants(): HasMany
    {
        return $this->hasMany(Entrant::class);
    }
}
