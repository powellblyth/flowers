<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Notifications\Notifiable;

//use Laravel\Cashier\Billable;

/**
 * App\Models\Team
 *
 * @property int $id
 * @property string $name
 * @property string|null $status
 * @property int|null $min_age
 * @property int|null $max_age
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Entrant[] $entrants
 * @property-read int|null $entrants_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Team[] $teams
 * @property-read int|null $teams_count
 * @method static \Illuminate\Database\Eloquent\Builder|Team newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team query()
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereMaxAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereMinAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Team extends Model
{
    use Notifiable;

    final const STATUS_ACTIVE = 'active';

    protected $attributes = [
        'status' => 'active',
    ];

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class);
    }

    public function entrants(): HasManyThrough
    {
        return $this->hasManyThrough(Entrant::class, TeamMembership::class);
    }

    public function entrantsForShow(Show $show): HasMany
    {
        return $this->teams()->where('show_id', $show->id)->where('');
    }
}
