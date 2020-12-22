<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Cup
 * @package App\Models
 * @property int id
 * @method static Builder orderBy(string $string, string $string1)
 */
class Cup extends Model
{
    public function getUrl(): string
    {
        return '/cups/' . $this->id;
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function getWinningResults(Show $show)
    {
        /**
         * @TODO imrove this with more laravelness
         */
        return \Illuminate\Support\Facades\DB::select("select sum(if(winningplace='1', 4,0)) as firstplacepoints, 
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
