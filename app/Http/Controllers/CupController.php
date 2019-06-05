<?php

namespace App\Http\Controllers;

use App\Category;
use App\Cup;
use App\CupDirectWinner;
use App\Entrant;
use App\Entry;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\View\View;

class CupController extends Controller {

    protected $templateDir = 'cups';
    protected $baseClass = 'App\Cup';

    public function index(array $extraData = []): View {
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
entrant_id from entries 

where category_id in (
select category_cup.category_id from category_cup where category_cup.cup_id = ?)
AND entries.year = ?
group by entrant_id

having (totalpoints > 0)
order by (totalpoints) desc", array($cup->id, env('CURRENT_YEAR', 2018)));

            $thisCupPoints = array();
            foreach ($resultset as $result) {
                $thisCupPoints[] = ['firstplacepoints' => $result->firstplacepoints,
                    'secondplacepoints' => $result->secondplacepoints,
                    'thirdplacepoints' => $result->thirdplacepoints,
                    'commendedplacepoints' => $result->commendedplacepoints,
                    'totalpoints' => $result->totalpoints,
                    'entrant' => $result->entrant_id];
                if (!array_key_exists($result->entrant_id, $winners)) {
                    $winners[$result->entrant_id] = ['entrant' => Entrant::find($result->entrant_id), 'points' => $result->totalpoints];
                }
            }

            $winningCategory = null;

            // Gather up more winners if needed
            $cupWinner = CupDirectWinner::where('cup_id', $cup->id)->where('year', env('CURRENT_YEAR', 2018))->first();
            if ($cupWinner instanceof CupDirectWinner) {
                if (!array_key_exists($cupWinner->entrant_id, $winners)) {
                    $winners[$cupWinner->entrant_id] = ['entrant' => Entrant::find($cupWinner->entrant_id), 'points' => 0];
                }
                $winningCategory = Category::where('id', $cupWinner->winning_category_id)->where('year', env('CURRENT_YEAR', 2018))->first();
            }

            $results[$cup->id] = array('results' => $thisCupPoints,
                'direct_winner' => (($cupWinner instanceof CupDirectWinner) ? $cupWinner->entrant_id : null),
//                var_dump($winningCategory)
                'winning_category' => $winningCategory);
        }

        return view($this->templateDir . '.index', array_merge($extraData, array('cups' => $cups,
            'results' => $results,
            'winners' => $winners,
            'isAdmin' => Auth::check() && Auth::User()->isAdmin()
        )));
    }

    public function show(int $id, array $showData = []): View {
        $winnerDataByCategory = [];
        $winners = [];
        $cup = Cup::find($id);

        $categories = $cup->categories()->where('year', env('CURRENT_YEAR'))->orderBy('sortorder')->get();
        foreach ($categories as $category) {
            $resultset = $category
                ->entries()
                ->selectRaw('if(winningplace=\'1\', 4,if(winningplace=\'2\',3, if(winningplace=\'3\',2, if(winningplace=\'commended\',1, 0 ) ) )) as points, winningplace, entrant_id')
                ->whereIn('winningplace', ['1', '2', '3', 'commended'])
                ->where('year', env('CURRENT_YEAR'))
                ->orderBy('winningplace', 'asc')
                ->get();

            $winnerDataByCategory[$category->id] = [];
            foreach ($resultset as $categoryWinners) {
                $winnerDataByCategory[$category->id][$categoryWinners->winningplace] = ['entrant' => $categoryWinners->entrant_id, 'place' => $categoryWinners->winningplace, 'points' => $categoryWinners->points];
                if (!array_key_exists($categoryWinners->entrant_id, $winners)) {
                    $winners[$categoryWinners->entrant_id] = Entrant::find($categoryWinners->entrant_id);
                }
            }
        }

        $validEntries = Entry::where('year', env('CURRENT_YEAR', 2018))->get();
        $people = [];
        foreach ($validEntries as $entry) {
            if ($entry->entrant instanceof Entrant) {
                $person = $entry->entrant;
                $people[$person->id] = $person->getName();
            } else {
                $people[$entry->entrant_id] = 'Unknown';
            }
        }
        unset($person);

        asort($people);
        $thing = $this->baseClass::find($id);
//        $showData = array_merge($extraData, array('thing' => $thing));
        return view($this->templateDir . '.show', [
            'thing' => $thing,
            'winners' => $winners,
            'winners_by_category' => $winnerDataByCategory,
            'categories' => $categories,
            'people' => $people,
            'isAdmin' => Auth::check() && Auth::User()->isAdmin()
        ]);

    }

//        public function storeresults(Request $request) {
//        foreach ($request->positions as $categoryId => $placings) {

    public function directResultPick(Request $request, int $id): View {

        $thing = Cup::find($id);
        $entriesObj = Entry::where('category', $request->category)->where('year', env('CURRENT_YEAR', 2018))->get();
        $entries = [];
        foreach ($entriesObj as $entry) {
            $entrant = $entry->entrant;
            $entries[$entry->id] = $entrant->getName();
        }
        return view($this->templateDir . '.directResultPickEntrant', ['entries' => $entries, 'id' => $id, 'thing' => $thing,
            'isAdmin' => Auth::check() && Auth::User()->isAdmin()]);
    }

    public function directResultSetWinner(Request $request, int $id): \Illuminate\Http\RedirectResponse {

        $entry = Entry::find($request->entry);
//        $thing = Cup::find($id);
//        $entries = Entrant::where('id', $request->entrant)->first();
        $cupDirectWinner = new CupDirectWinner();
        $cupDirectWinner->cup = $id;
        $cupDirectWinner->winning_entry_id = $entry->id;
        $cupDirectWinner->year = env('CURRENT_YEAR', 2018);
        $cupDirectWinner->entrant_id = $entry->entrant_id;
        $cupDirectWinner->winning_category_id = $entry->category_id;
        $cupDirectWinner->save();

        return redirect('/cups/' . $id);
    }

    public function directResultSetWinnerPerson(Request $request, int $id): \Illuminate\Http\RedirectResponse {

//        $entry = Entry::find($request->entry);
//        $thing = Cup::find($id);
//        $entries = Entrant::where('id', $request->entrant)->first();
        $cupDirectWinner = new CupDirectWinner();
        $cupDirectWinner->cup = $id;
        $cupDirectWinner->year = env('CURRENT_YEAR', 2018);
        $cupDirectWinner->entrant_id = $request->person;
        $cupDirectWinner->save();

        return redirect('/cups/' . $id);
    }
}
