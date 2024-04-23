<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;

/**
 * App\Models\Show
 *
 * @property int $id
 * @property string $name
 * @property Carbon $start_date
 * @property Carbon $ends_date
 * @property Carbon $late_entry_deadline
 * @property Carbon $entries_closed_deadline
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Category[] $categories
 * @property-read int|null $categories_count
 * @property-read Collection|Entry[] $entries
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
 * @property string|null $slug
 * @property-read Collection<int, RafflePrize> $rafflePrizes
 * @property-read int|null $raffle_prizes_count
 * @method static Builder|Show newestFirst()
 * @method static Builder|Show public ()
 * @method static Builder|Show whereSlug($value)
 * @mixin \Eloquent
 */
class Show extends Model
{
    use HasSortableRows;

    protected $fillable = [
        'name',
        'start_date',
        'ends_date',
        'late_entry_deadline',
        'entries_closed_deadline',
        'status'
    ];

    protected $casts = [
        'late_entry_deadline' => 'datetime',
        'entries_closed_deadline' => 'datetime',
        'ends_date' => 'datetime',
        'start_date' => 'datetime:Y-m-d H:i',
    ];

    protected $attributes = [
        'status' => self::STATUS_PLANNED,
    ];

    final const STATUS_CURRENT = 'current';
    final const STATUS_PLANNED = 'planned';
    final const STATUS_PASSED = 'passed';
    final const STATUS_CANCELLED = 'cancelled';

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function isCurrent(): bool
    {
        return $this->status == self::STATUS_CURRENT;
    }

    public function isPublic(): bool
    {
        return in_array($this->status, [self::STATUS_CURRENT, self::STATUS_PASSED]);
    }

    /****   Scopes   ****/
    public function scopePublic(Builder $query): Builder
    {
        return $query->whereIn($this->getTable() . '.status', [self::STATUS_CURRENT, self::STATUS_PASSED]);
    }

    /****   Scopes   ****/
    public function scopeNewestFirst(Builder $query): Builder
    {
        return $query->orderBy($this->getTable() . '.start_date', 'desc');
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

    public function rafflePrizes(): HasMany
    {
        return $this->HasMany(RafflePrize::class);
    }

    public function sections(): HasMany
    {
        return $this->HasMany(Section::class);
    }

    public function resultsArePublic(): bool
    {
        return $this->ends_date->isBefore(Carbon::now());
    }

    /**
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();
        static::saving(function ($show) {
            $show->slug = Str::slug($show->name);
        });
    }
}
