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

    protected function getYearFromRequest(Request $request): int {
        if ($request->has = ('year') && is_numeric($request->year) && (int)$request->year > 2015 && (int)$request->year < (int)date('Y')) {
            return (int)$request->year;
        } else {
            return config('app.year');
        }
    }


    public function index(Request $request): View {
        $year = $this->getYearFromRequest($request);
        $winners = array();
        $results = array();
//        $cups = Cup::
        $cups = Cup::orderBy('sort_order', 'asc')->get();

        /** dragons here - copied tp printableresults */
        foreach ($cups as $cup) {
            $resultset = $cup->getWinningResults($year);
//var_dump($resultset);
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
            $cupWinner = CupDirectWinner::where('cup_id', $cup->id)->where('year', $year)->first();
            if ($cupWinner instanceof CupDirectWinner) {
                if (!array_key_exists($cupWinner->entrant_id, $winners)) {
                    $winners[$cupWinner->entrant_id] = ['entrant' => Entrant::find($cupWinner->entrant_id), 'points' => 0];
                }
                $winningCategory = Category::where('id', $cupWinner->winning_category_id)->where('year',$year)->first();
            }

            $results[$cup->id] = array('results' => $thisCupPoints,
                'direct_winner' => (($cupWinner instanceof CupDirectWinner) ? $cupWinner->entrant_id : null),
//                var_dump($winningCategory)
                'winning_category' => $winningCategory);
        }

        return view($this->templateDir . '.index', ['cups' => $cups,
            'results' => $results,
            'winners' => $winners,
            'year' => $year,
            'isAdmin' => Auth::check() && Auth::User()->isAdmin()
        ]);
    }

    public function show(int $id , Request $request): View {
        $winnerDataByCategory = [];
        $winners = [];
        $cup = Cup::find($id);
        $year = $this->getYearFromRequest($request);

        $categories = $cup->categories()->where('year', $year)->orderBy('sortorder')->get();
        foreach ($categories as $category) {
            $resultset = $category
                ->entries()
                ->selectRaw('if(winningplace=\'1\', 4,if(winningplace=\'2\',3, if(winningplace=\'3\',2, if(winningplace=\'commended\',1, 0 ) ) )) as points, winningplace, entrant_id')
                ->whereIn('winningplace', ['1', '2', '3', 'commended'])
                ->where('year', $year)
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

        $isCurrentYear = ($year === (int)date('Y'));
        $people = [];
        if ($isCurrentYear){
            $validEntries = Entry::where('year', $year)->get();
            foreach ($validEntries as $entry) {
                if ($entry->entrant instanceof Entrant) {
                    $person = $entry->entrant;
                    $people[$person->id] = $person->getName();
                } else {
                    $people[$entry->entrant_id] = 'Unknown';
                }
            }
            unset($person);
        }else{$validEntries = null;}

        asort($people);
        $thing = $this->baseClass::find($id);
//        $showData = array_merge($extraData, array('thing' => $thing));
        return view($this->templateDir . '.show', [
            'thing' => $thing,
            'winners' => $winners,
            'winners_by_category' => $winnerDataByCategory,
            'categories' => $categories,
            'people' => $people,
            'isAdmin' => Auth::check() && Auth::User()->isAdmin(),
            'year'=>$year,
            'is_current_year'=>$isCurrentYear,
        ]);

    }
    public function printableresults(Request $request){
        $year = $this->getYearFromRequest($request);
        $showAddress = $request->has('show_address') || $request->has('showaddress') || $request->has('showAddress');
        $winners = array();
        $results = array();
        $cups = Cup::orderBy('sort_order', 'asc')->get();
//var_dump($year);
        /** dragons here - copied from index*/
        foreach ($cups as $cup) {
            $resultset = $cup->getWinningResults($year);
//var_Dump($resultset);
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
            $cupWinner = CupDirectWinner::where('cup_id', $cup->id)->where('year', $year)->first();
            if ($cupWinner instanceof CupDirectWinner) {
                if (!array_key_exists($cupWinner->entrant_id, $winners)) {
                    $winners[$cupWinner->entrant_id] = ['entrant' => Entrant::find($cupWinner->entrant_id), 'points' => 0];
                }
                $winningCategory = Category::where('id', $cupWinner->winning_category_id)->where('year',$year)->first();
            }

            $results[$cup->id] = array('results' => $thisCupPoints,
                'direct_winner' => (($cupWinner instanceof CupDirectWinner) ? $cupWinner->entrant_id : null),
//                var_dump($winningCategory)
                'winning_category' => $winningCategory);
        }
//var_dump($winners);
        return view($this->templateDir . '.publishablesnippet', ['cups' => $cups,
            'results' => $results,
            'winners' => $winners,
            'year' => $year,
            'isAdmin' => Auth::check() && Auth::User()->isAdmin(),
            'showAddress' => $showAddress,

        ]);
    }

//        public function storeresults(Request $request) {
//        foreach ($request->positions as $categoryId => $placings) {

    public function directResultPick(Request $request, int $id): View {

        $thing = Cup::find($id);
        $entriesObj = Entry::where('category', $request->category)->where('year', config('app.year'))->get();
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
        $cupDirectWinner->year = config('app.year');
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
        $cupDirectWinner->year = config('app.year');
        $cupDirectWinner->entrant_id = $request->person;
        $cupDirectWinner->save();

        return redirect('/cups/' . $id);
    }



}
