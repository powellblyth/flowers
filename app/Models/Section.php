<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\Section
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $number
 * @property string|null $notes
 * @property string|null $judges
 * @property string|null $image
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Category[] $categories
 * @property-read int|null $categories_count
 * @property-read string $display_name
 * @method static Builder|Section newModelQuery()
 * @method static Builder|Section newQuery()
 * @method static Builder|Section query()
 * @method static Builder|Section whereCreatedAt($value)
 * @method static Builder|Section whereId($value)
 * @method static Builder|Section whereImage($value)
 * @method static Builder|Section whereJudges($value)
 * @method static Builder|Section whereName($value)
 * @method static Builder|Section whereNotes($value)
 * @method static Builder|Section whereNumber($value)
 * @method static Builder|Section whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property bool $is_junior
 * @method static Builder|Section whereIsJunior($value)
 */
class Section extends Model
{
    protected $attributes = [
        'is_junior' => 'bool',
    ];

    public function displayName(): Attribute
    {
        return new Attribute(
            get: fn($value) => $this->number . ' - ' . $this->name
        );
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function judgeRole(): BelongsTo
    {
        return $this->belongsTo(JudgeRole::class);
    }
}
