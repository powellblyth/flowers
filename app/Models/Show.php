<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static Builder where(string $column, string $value)
 * @method static Show findOrFail(int $param)
 * @property Carbon late_entry_deadline
 * @property Carbon entries_closed_deadline
 * @property Carbon end_date
 * @property Carbon start_date
 * @property string status
 * @property int id
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
    const STATUS_CURRENT = 'current';
    const STATUS_PASSED  = 'passed';
    const STATUS_PLANNED = 'planned';

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
