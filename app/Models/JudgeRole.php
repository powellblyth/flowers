<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class JudgeRole
 *
 * @package App\Models
 * @mixin \Eloquent
 * @property int $id
 * @property string $label
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cup[] $cups
 * @property-read int|null $cups_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Judge[] $judges
 * @property-read int|null $judges_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Section[] $sections
 * @property-read int|null $sections_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Show[] $shows
 * @property-read int|null $shows_count
 * @method static \Illuminate\Database\Eloquent\Builder|JudgeRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JudgeRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JudgeRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|JudgeRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JudgeRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JudgeRole whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JudgeRole whereUpdatedAt($value)
 */
class JudgeRole extends Model
{
    use HasFactory;

    public $attributes = [
    ];

    public $casts = [
    ];

    /****   Attributes   ****/

    /****   Scopes   ****/

    /****   Relations   ****/

    public function judges(): HasMany
    {
        return $this->hasMany(Judge::class);
    }

    public function shows(): BelongsToMany
    {
        return $this->belongsToMany(Show::class)
            ->withPivot('judge_role')
            ->withTimestamps();
    }

    public function sections(): BelongsToMany
    {
        return $this->BelongsToMany(Section::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->BelongsToMany(Category::class);
    }
    public function cups(): BelongsToMany
    {
        return $this->BelongsToMany(Cup::class);
    }

    /****   Checks   ****/

    /****   Methods   ****/

    /****   Statics   ****/

}
