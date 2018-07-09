<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CupToCategory;
use App\Cup;
use App\CupDirectWinner;
use App\Category;
use App\Entrant;
use App\Entry;
use DB;

class CupController extends Controller {

    protected $templateDir = 'cups';
    protected $baseClass = 'App\Cup';

    public function index($extraData = []) {
        $winners = array();
        $results = array();
//        $cups = Cup::
        $cups = $this->baseClass::orderBy('sort_order', 'asc')->get();

//->where('year', env('CURRENT_YEAR', 2018))
        foreach ($cups as $cup) {
            $resultset = DB::select("select sum(if(winningplace='1', 4,0)) as firstplacepoints, 
sum(if(winningplace='2', 3,0) ) as secondplacepoints, 
sum(if(winningplace='3', 2,0)) as thirdplacepoints, 
sum(if(winningplace='commended', 1,0)) as commendedplacepoints, 
sum(if(winningplace='1', 4,0) + if(winningplace='2', 3,0) + if(winningplace='3', 2,0) + if(winningplace='commended', 1,0)) as totalpoints,
entrant from entries 

where category in (
select cup_to_categories.category from cup_to_categories where cup_to_categories.cup = ?)
AND entries.year = ?
group by entrant

having (totalpoints > 0)
order by (totalpoints) desc", array($cup->id, env('CURRENT_YEAR', 2018)));

            $thisCupPoints = array();
            foreach ($resultset as $result) {
                $thisCupPoints[] = ['firstplacepoints' => $result->firstplacepoints,
                    'secondplacepoints' => $result->secondplacepoints,
                    'thirdplacepoints' => $result->thirdplacepoints,
                    'commendedplacepoints' => $result->commendedplacepoints,
                    'totalpoints' => $result->totalpoints,
                    'entrant' => $result->entrant];
                if (!array_key_exists($result->entrant, $winners)) {
                    $winners[$result->entrant] = ['entrant' => Entrant::find($result->entrant), 'points' => $result->totalpoints];
                }
            }

            $winningCategory = null;

            // Gather up more winners if needed
            $cupWinner = CupDirectWinner::where('cup', $cup->id)->where('year', env('CURRENT_YEAR', 2018))->first();
            if ($cupWinner instanceof CupDirectWinner) {
                if (!array_key_exists($cupWinner->entrant, $winners)) {
                    $winners[$cupWinner->entrant] = ['entrant' => Entrant::find($cupWinner->entrant), 'points' => 0];
                }
                $winningCategory = Category::where('id', $cupWinner->winning_category)->where('year', env('CURRENT_YEAR', 2018))->first();
            }

            $results[$cup->id] = array('results' => $thisCupPoints,
                'direct_winner' => (($cupWinner instanceof CupDirectWinner ) ? $cupWinner->entrant : null),
//                var_dump($winningCategory)
                'winning_category' => $winningCategory);
        }

        return view($this->templateDir . '.index', array_merge($extraData, array('cups' => $cups,
            'results' => $results,
            'winners' => $winners
        )));
    }

    public function show($id, $showData = []) {
        $winnerDataByCategory = [];
        $winners = [];

        $cupLinks = CupToCategory::where('cup', (int) $id)->get();
        $categoryData = [];
        foreach ($cupLinks as $cupLink) {
            $resultset = DB::select("select if(winningplace='1', 4,if(winningplace='2',3, if(winningplace='3',2, if(winningplace='commended',1, 0 ) ) )) as points, 
winningplace,
entrant 

from entries 

where category = ?
AND winningplace IN ('1','2','3','commended')
AND year = ?
order by (winningplace) ASC", array($cupLink->category, env('CURRENT_YEAR', 2018)));

            $winnerDataByCategory[$cupLink->category] = array();
            foreach ($resultset as $categoryWinners) {
                $winnerDataByCategory[$cupLink->category][$categoryWinners->winningplace] = ['entrant' => $categoryWinners->entrant, 'place' => $categoryWinners->winningplace, 'points' => $categoryWinners->points];
                if (!array_key_exists($categoryWinners->entrant, $winners)) {
                    $winners[$categoryWinners->entrant] = Entrant::find($categoryWinners->entrant);
                }
            }

            $categoryData[$cupLink->category] = Category::find($cupLink->category);
        }
        $categories = [];
        if (0 == count($cupLinks)) {
            $categoriesObj = Category::orderBy('sortorder')->where('year', env('CURRENT_YEAR', 2018))->get();
            foreach ($categoriesObj as $category) {
                $categories[$category->id] = $category->getNumberedLabel();
            }
        }

        $validEntries = Entry::where('year', env('CURRENT_YEAR', 2018))->get();
        $people = [];
        foreach ($validEntries as $entry) {
            $person = Entrant::find($entry->entrant);
            $people[$person->id] = $person->getName();
        }
        unset($person);
//        $people = Entrant::orderBy('familyName', 'ASC')->orderBy('firstName', 'asc')->get();
//        foreahc 
        asort($people);
        return parent::show($id, array_merge($showData, array('category_data' => $categoryData,
                'cup_links' => $cupLinks,
                'winners' => $winners,
                'winners_by_category' => $winnerDataByCategory,
                'categories' => $categories,
                'people' => $people
        )));
    }

//        public function storeresults(Request $request) {
//        foreach ($request->positions as $categoryId => $placings) {

    public function directResultPick(Request $request, int $id) {

        $thing = Cup::find($id);
        $entriesObj = Entry::where('category', $request->category)->where('year', env('CURRENT_YEAR', 2018))->get();
        $entries = [];
        foreach ($entriesObj as $entry) {
            $entrant = Entrant::find($entry->entrant);
            $entries[$entry->id] = $entrant->getName();
        }
        return view($this->templateDir . '.directResultPickEntrant', ['entries' => $entries, 'id' => $id, 'thing' => $thing]);
    }

    public function directResultSetWinner(Request $request, int $id) {

        $entry = Entry::find($request->entry);
//        $thing = Cup::find($id);
//        $entries = Entrant::where('id', $request->entrant)->first();
        $cupDirectWinner = new CupDirectWinner();
        $cupDirectWinner->cup = $id;
        $cupDirectWinner->winning_entry = $entry->id;
        $cupDirectWinner->year = env('CURRENT_YEAR', 2018);
        $cupDirectWinner->entrant = $entry->entrant;
        $cupDirectWinner->winning_category = $entry->category;
        $cupDirectWinner->save();

        return redirect('/cups/' . $id);
    }

    public function directResultSetWinnerPerson(Request $request, int $id) {

//        $entry = Entry::find($request->entry);
//        $thing = Cup::find($id);
//        $entries = Entrant::where('id', $request->entrant)->first();
        $cupDirectWinner = new CupDirectWinner();
        $cupDirectWinner->cup = $id;
        $cupDirectWinner->year = env('CURRENT_YEAR', 2018);
        $cupDirectWinner->entrant = $request->person;
        $cupDirectWinner->save();

        return redirect('/cups/' . $id);
    }
}
