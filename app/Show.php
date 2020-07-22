<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static where(string $column, string $value)
 * @property Carbon late_entry_deadline
 * @property Carbon entries_closed_deadline
 * @property Carbon end_date
 * @property Carbon start_date
 */
class Show extends Model
{
    protected $fillable = [
        'name', 'start_date', 'ends_date', 'late_entry_deadline', 'entries_closed_deadline', 'status'
    ];

    protected $casts = [
        'late_entry_deadline'     => 'datetime',
        'entries_closed_deadline' => 'datetime',
        'ends_date'               => 'datetime',
        'start_date'              => 'datetime',
    ];

    const STATUS_CURRENT = 'current';

    public function isCurrent(): bool
    {
        return $this->status == self::STATUS_CURRENT;
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
