<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Cup
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $direct_winner
 * @property string|null $winning_category
 * @property int|null $calculated_winner
 * @property string|null $winning_criteria
 * @property int|null $sort_order
 * @property int|null $num_display_results
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $categories
 * @property-read int|null $categories_count
 * @method static \Illuminate\Database\Eloquent\Builder|Cup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cup query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cup whereCalculatedWinner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cup whereDirectWinner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cup whereNumDisplayResults($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cup whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cup whereWinningCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cup whereWinningCriteria($value)
 * @mixin \Eloquent
 */
class Cup extends Model
{
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function getWinningResults(Show $show)
    {
        /**
         * @TODO imrove this with more laravelness
         */
        return DB::select("select sum(if(winningplace='1', 4,0)) as firstplacepoints, 
sum(if(winningplace='2', 3,0) ) as secondplacepoints, 
sum(if(winningplace='3', 2,0)) as thirdplacepoints, 
sum(if(winningplace='commended', 1,0)) as commendedplacepoints, 
sum(if(winningplace='1', 4,0) + if(winningplace='2', 3,0) + if(winningplace='3', 2,0) + if(winningplace='commended', 1,0)) as totalpoints,
entrant_id from entries 

where category_id in (
select category_cup.category_id from category_cup where category_cup.cup_id = ?)
AND entries.show_id = ?
group by entrant_id

having (totalpoints > 0)
order by (totalpoints) desc", array($this->id, $show->id));
    }
}
