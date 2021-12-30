<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

//use Laravel\Cashier\Billable;

/**
 * App\Models\Team
 *
 * @property int $id
 * @property string $name
 * @property string|null $status
 * @property int|null $min_age
 * @property int|null $max_age
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read Collection|\App\Models\Entrant[] $entrants
 * @property-read int|null $entrants_count
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|Team[] $teams
 * @property-read int|null $teams_count
 * @method static Builder|Team newModelQuery()
 * @method static Builder|Team newQuery()
 * @method static Builder|Team query()
 * @method static Builder|Team whereCreatedAt($value)
 * @method static Builder|Team whereDeletedAt($value)
 * @method static Builder|Team whereId($value)
 * @method static Builder|Team whereMaxAge($value)
 * @method static Builder|Team whereMinAge($value)
 * @method static Builder|Team whereName($value)
 * @method static Builder|Team whereStatus($value)
 * @method static Builder|Team whereUpdatedAt($value)
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
