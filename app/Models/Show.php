<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Show
 *
 * @property int $id
 * @property string $name
 * @property \datetime $start_date
 * @property \Illuminate\Support\Carbon $ends_date
 * @property \Illuminate\Support\Carbon $late_entry_deadline
 * @property \Illuminate\Support\Carbon $entries_closed_deadline
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Collection|\App\Models\Category[] $categories
 * @property-read int|null $categories_count
 * @property-read Collection|\App\Models\Entry[] $entries
 * @property-read int|null $entries_count
 * @method static Builder|Show newModelQuery()
 * @method static Builder|Show newQuery()
 * @method static Builder|Show query()
 * @method static Builder|Show whereCreatedAt($value)
 * @method static Builder|Show whereEndsDate($value)
 * @method static Builder|Show whereEntriesClosedDeadline($value)
 * @method static Builder|Show whereId($value)
 * @method static Builder|Show whereLateEntryDeadline($value)
 * @method static Builder|Show whereName($value)
 * @method static Builder|Show whereStartDate($value)
 * @method static Builder|Show whereStatus($value)
 * @method static Builder|Show whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Show extends Model
{
    protected $fillable = [
        'name',
        'start_date',
        'ends_date',
        'late_entry_deadline',
        'entries_closed_deadline',
        'status'
    ];

    protected $casts = [
        'late_entry_deadline'     => 'datetime',
        'entries_closed_deadline' => 'datetime',
        'ends_date'               => 'datetime',
        'start_date'              => 'datetime:Y-m-d H:i',
    ];

    protected $attributes = [
        'status' => self::STATUS_PLANNED,
    ];

    final const STATUS_CURRENT = 'current';
    final const STATUS_PLANNED = 'planned';

    public function isCurrent(): bool
    {
        return $this->status == self::STATUS_CURRENT;
    }

    public function isClosedToEntries(): bool
    {
        return $this->entries_closed_deadline <= Carbon::now();
    }

    public function entries(): HasMany
    {
        return $this->hasMany(Entry::class);
    }

    public function categories(): HasMany
    {
        return $this->HasMany(Category::class);
    }
}
