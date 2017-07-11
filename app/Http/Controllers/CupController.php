<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CupToCategory;
use App\Cup;
use App\Category;
use App\Entrant;
use DB;

class CupController extends Controller
{
    protected $templateDir = 'cups';
    protected $baseClass = 'App\Cup';

    public function index($extraData = [])
    {
        $winners = array();
        $results = array();
//        $cups = Cup::
        $cups = $this->baseClass::orderBy('sort_order', 'asc')->get();
        foreach ($cups as $cup)
        {
        $resultset = DB::select("select sum(if(winningplace='1', 4,0)) as firstplacepoints, 
sum(if(winningplace='2', 3,0) ) as secondplacepoints, 
sum(if(winningplace='3', 2,0)) as thirdplacepoints, 
sum(if(winningplace='commended', 1,0)) as commendedplacepoints, 
sum(if(winningplace='1', 4,0) + if(winningplace='2', 3,0) + if(winningplace='3', 2,0) + if(winningplace='commended', 1,0)) as totalpoints,
entrant from entries 

where category in (
select cup_to_categories.category from cup_to_categories where cup_to_categories.cup = ?)

group by entrant

having (totalpoints > 0)
order by (totalpoints) desc", array($cup->id));
        
            $thisCupPoints = array();        
            foreach ($resultset as $result)
            {
                $thisCupPoints[] = ['firstplacepoints'=>$result->firstplacepoints,
                    'secondplacepoints'=>$result->secondplacepoints,
                    'thirdplacepoints'=>$result->thirdplacepoints,
                    'commendedplacepoints'=>$result->commendedplacepoints,
                    'totalpoints'=>$result->totalpoints,
                    'entrant'=>$result->entrant];
                if (!array_key_exists($result->entrant, $winners)) {
                    $winners[$result->entrant] = ['entrant' => Entrant::find($result->entrant), 'points'=>$result->totalpoints];
                }

            }
            if ((int)$cup->direct_winner  >0)
            {
                if (!array_key_exists($cup->direct_winner, $winners)) {
                    $winners[$cup->direct_winner] = ['entrant' => Entrant::find($cup->direct_winner), 'points'=>0];
                }

            }
            $results[$cup->id] = array('results' =>$thisCupPoints, 'direct_winner'=>$cup->direct_winner, 'winning_category'=>$cup->winning_category);
        }

        return view($this->templateDir . '.index', array_merge($extraData, array('cups' => $cups, 'results' => $results, 'winners'=>$winners)));
    }
    
    public function show($id, $showData = [])
    {
        $winnerDataByCategory = [];
        $winners = [];
        
        $cupLinks = CupToCategory::where('cup',(int)$id)->get();
        $categoryData = [];
        foreach ($cupLinks as $cupLink)
        {
$resultset = DB::select("select if(winningplace='1', 4,if(winningplace='2',3, if(winningplace='3',2, if(winningplace='commended',1, 0 ) ) )) as points, 
winningplace,
entrant 

from entries 

where category = ?
AND winningplace IN ('1','2','3','commended')

order by (winningplace) ASC", array($cupLink->category));            

            $winnerDataByCategory[$cupLink->category] = array();
            foreach ($resultset as $categoryWinners)
            {
                $winnerDataByCategory[$cupLink->category][$categoryWinners->winningplace] = ['entrant'=>$categoryWinners->entrant, 'place'=>$categoryWinners->winningplace, 'points'=>$categoryWinners->points];
                if (!array_key_exists($categoryWinners->entrant, $winners))
                {
                    $winners[$categoryWinners->entrant] = Entrant::find($categoryWinners->entrant);
                }
            }
            
            $categoryData[$cupLink->category] = Category::find($cupLink->category);
        }
         return parent::show($id, array_merge($showData,
                array('category_data' => $categoryData, 
                    'cup_links' => $cupLinks,
                    'winners' => $winners,
                    'winners_by_category' => $winnerDataByCategory
                    )));
    }
//
}
