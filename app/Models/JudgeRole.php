<?php

namespace App\Models;

use App\Traits\BelongsToShow;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Class JudgeRole
 *
 * @package App\Models
 * @property int $id
 * @property string $label
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Category[] $categories
 * @property-read int|null $categories_count
 * @property-read Collection|Cup[] $cups
 * @property-read int|null $cups_count
 * @property-read Collection|Judge[] $judges
 * @property-read int|null $judges_count
 * @property-read Collection|Section[] $sections
 * @property-read int|null $sections_count
 * @property-read Collection|Show[] $shows
 * @property-read int|null $shows_count
 * @method static Builder|JudgeRole newModelQuery()
 * @method static Builder|JudgeRole newQuery()
 * @method static Builder|JudgeRole query()
 * @method static Builder|JudgeRole whereCreatedAt($value)
 * @method static Builder|JudgeRole whereId($value)
 * @method static Builder|JudgeRole whereLabel($value)
 * @method static Builder|JudgeRole whereUpdatedAt($value)
 * @mixin \Eloquent
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
        return $this->belongsToMany(Show::class, 'judge_show')
//            ->withPivot('judge_show')
            ->withTimestamps();
    }

    public function judgesForShow(Show $show): BelongsToMany
    {
        return $this->belongsToMany(Judge::class, 'judge_show')
            ->withPivot('show_id')
            ->withTimestamps();
    }

    public function judgeAppointments(Show $show): BelongsToMany
    {
        return $this->hasMany(JudgeAtShow::class)
            ->withPivot('show_id', $show->id)
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
