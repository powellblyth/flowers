<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Cup extends Model
{
    public function getUrl()
    {
        return '/cups/'.$this->id;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function getWinningResults($year = 2015)
    {
        return DB::select("select sum(if(winningplace='1', 4,0)) as firstplacepoints, 
sum(if(winningplace='2', 3,0) ) as secondplacepoints, 
sum(if(winningplace='3', 2,0)) as thirdplacepoints, 
sum(if(winningplace='commended', 1,0)) as commendedplacepoints, 
sum(if(winningplace='1', 4,0) + if(winningplace='2', 3,0) + if(winningplace='3', 2,0) + if(winningplace='commended', 1,0)) as totalpoints,
entrant_id from entries 

where category_id in (
select category_cup.category_id from category_cup where category_cup.cup_id = ?)
AND entries.year = ?
group by entrant_id

having (totalpoints > 0)
order by (totalpoints) desc", array($this->id, $year));
    }
}
