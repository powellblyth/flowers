<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Cup
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $winning_criteria
 * @property int|null $sort_order
 * @property int|null $num_display_results
 * @property-read Collection|Category[] $categories
 * @property-read int|null $categories_count
 * @method static Builder|Cup newModelQuery()
 * @method static Builder|Cup newQuery()
 * @method static Builder|Cup query()
 * @method static Builder|Cup whereCreatedAt($value)
 * @method static Builder|Cup whereId($value)
 * @method static Builder|Cup whereName($value)
 * @method static Builder|Cup whereNumDisplayResults($value)
 * @method static Builder|Cup whereSortOrder($value)
 * @method static Builder|Cup whereUpdatedAt($value)
 * @method static Builder|Cup whereWinningCriteria($value)
 * @mixin \Eloquent
 * @property int|null $section_id
 * @property-read Section|null $section
 * @method static Builder|Cup whereSectionId($value)
 */
class Cup extends Model
{
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function relatedCategories(Show $show): Collection
    {
        if ($this->section) {
            return $this
                ->section
                ->categories()
                ->where('show_id', $show->id)
                ->get();
        } else {
            return $this->categories()->where('show_id', $show->id)->get();
        }
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function cupDirectWinner(): HasMany
    {
        return $this->hasMany(CupDirectWinner::class);
    }

    public function getWinningResults(Show $show)
    {
        /**
         * @TODO improve this with more laravelness
         */
        $categoryIds = $this->getValidCategoryIdsForShow($show);

        return DB::select(
            "
            select sum(if(winningplace='1', 4,0)) as firstplacepoints, 
                sum(if(winningplace='2', 3,0) ) as secondplacepoints, 
                sum(if(winningplace='3', 2,0)) as thirdplacepoints, 
                sum(if(winningplace='commended', 1,0)) as commendedplacepoints, 
                sum(
                    if(winningplace='1', 4,0) 
                        + if(winningplace='2', 3,0) 
                        + if(winningplace='3', 2,0) 
                        + if(winningplace='commended', 1,0)
                    ) as totalpoints,
                entrant_id 
            
            from entries 
            
            where 
                category_id in (?)
                AND entries.show_id = ?
            
            group by entrant_id
            
            having (totalpoints > 0)
            order by (totalpoints) desc
",
            array(implode(',', $categoryIds), $show->id)
        );
    }

    private function getValidCategoryIdsForShow(Show $show): array
    {
        if ($this->section_id) {
            return $this->section->categories()->forShow($show)->pluck('id')->toArray();
        } else {
            return $this->relatedCategories($show)->pluck('id')->toArray();
        }
    }
}
