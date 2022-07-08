<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;

/**
 * Class Judge
 *
 * @package App\Models
 * @mixin Model
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $cv
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Judge newModelQuery()
 * @method static Builder|Judge newQuery()
 * @method static Builder|Judge query()
 * @method static Builder|Judge whereCreatedAt($value)
 * @method static Builder|Judge whereCv($value)
 * @method static Builder|Judge whereDescription($value)
 * @method static Builder|Judge whereId($value)
 * @method static Builder|Judge whereName($value)
 * @method static Builder|Judge whereUpdatedAt($value)
 */
class Judge extends Model
{
    use HasFactory;

    public $attributes = [
    ];

    public $casts = [
    ];

    /****   Attributes   ****/

    /****   Scopes   ****/

    /****   Relations   ****/
    public function judgeAtShow(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(JudgeAtShow::class);
    }

    public function getJudgeRolesForShow(Show $show)
    {
        $judgeAtShows = $this->judgeAtShow()
            ->with(['judgeRole', 'show', 'show.categories', 'show.categories.section', 'judgeRole.cups'])
            ->where('show_id', $show->id)
            ->get();
        /** @var Collection<JudgeRole> $judgeRoles **/
        $judgeRoles = new Collection();
        foreach ($judgeAtShows as $judgeAtShow) {
            /** @var JudgeAtShow $judgeAtShow */
            $judgeRoles->add($judgeAtShow->judgeRole);
        }
        return $judgeRoles;
    }

    public function relatedCategories(Show $show): Collection
    {
        $judgeRoles = $this->getJudgeRolesForShow($show);
        $categories = new Collection();
        foreach ($judgeRoles as $judgeRole) {
            /** @var Collection <Section> $sections */
            $sections = Section::where('judge_role_id', $judgeRole->id)->get();
            foreach ($sections as $section) {
                $categories = $categories->merge(
                    $section->categories()
                        ->with('section')
                        ->where('section_id', $section->id)
                        ->where('show_id', $show->id)
                        ->get()
                );
            }
            foreach ($show->categories()->with('section')->get() as $showCategory) {
                $hasJudgeRole = $showCategory->judgeRoles()->where('judge_role_id', $judgeRole->id)->first();
                if ($hasJudgeRole) {
                    $categories->add($showCategory);
                }
            }
        }
        return $categories->sortBy('sortorder');
    }

    public function relatedCups(Show $show): Collection
    {
        $judgeRoles = $this->getJudgeRolesForShow($show);
        $cups = new Collection();
        foreach ($judgeRoles as $judgeRole) {
            /** @var JudgeRole $judgeRole */
            $cups = $cups->merge($judgeRole->cups);
        }
        return $cups->sortBy('sort_order');
    }

    /****   Checks   ****/

    /****   Methods   ****/

    /****   Statics   ****/

}
