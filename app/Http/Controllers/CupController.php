<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Cup;
use App\Models\CupDirectWinner;
use App\Models\Entrant;
use App\Models\Entry;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CupController extends Controller
{

    public function index(Request $request): View
    {
        $show = $this->getShowFromRequest($request);
        $winners = array();
        $results = array();
        $cups = Cup::orderBy('sort_order', 'asc')->get();
        /** dragons here - copied tp printableresults */
        foreach ($cups as $cup) {
            /** @var Cup $cup */
            $resultset = $cup->getWinningResults($show);
            $thisCupPoints = array();
            foreach ($resultset as $result) {
                $thisCupPoints[] = ['firstplacepoints' => $result->firstplacepoints,
                                    'secondplacepoints' => $result->secondplacepoints,
                                    'thirdplacepoints' => $result->thirdplacepoints,
                                    'commendedplacepoints' => $result->commendedplacepoints,
                                    'totalpoints' => $result->totalpoints,
                                    'entrant' => $result->entrant_id];
                if (!array_key_exists($result->entrant_id, $winners)) {
                    $winners[$result->entrant_id] =
                        [
                            'entrant' => Entrant::find($result->entrant_id),
                            'points' => $result->totalpoints
                        ];
                }
            }

            $winningCategory = null;

            // Gather up more winners if needed
            $cupWinner = CupDirectWinner::with('entrant')
                ->where('cup_id', $cup->id)
                ->where('show_id', $show->id)
                ->first();
            if ($cupWinner instanceof CupDirectWinner) {
//                dd($cupWinner->winningEntry);
                /** @var CupDirectWinner $cupWinner */
//                if(!$cupWinner->winningEntry) {
//                   dd($cupWinner->winning_entry_id);
//                }
                if ($cupWinner->winningEntry && !array_key_exists($cupWinner->winningEntry->entrant->id, $winners)) {
                    $winners[$cupWinner->winningEntry->entrant->id] =
                        [
                            'entrant' => $cupWinner->winningEntry->entrant,
                            'points' => 0,
                        ];
                }
                $winningCategory = $cupWinner->winningCategory()
                    ->where('show_id', $show->id)
                    ->first();
            }

            $results[$cup->id] = array('results' => $thisCupPoints,
                                       'direct_winner' => (($cupWinner instanceof CupDirectWinner) ? $cupWinner->entrant_id : null),
                                       'winning_category' => $winningCategory);
        }
        return view('cups.index', ['cups' => $cups,
                                   'results' => $results,
                                   'winners' => $winners,
                                   'show' => $show,
                                   'isAdmin' => Auth::check() && Auth::User()->isAdmin(),
        ]);
    }

    public function show(Cup $cup, Request $request): View
    {
        $winnerDataByCategory = [];
        $winners = [];
        $show = $this->getShowFromRequest($request);

        $categories = $cup->categories()->where('show_id', $show->id)->orderBy('sortorder')->get();

        foreach ($categories as $category) {
            $resultset = $category
                ->entries()
                ->selectRaw('if(winningplace=\'1\', 4,if(winningplace=\'2\',3, if(winningplace=\'3\',2, if(winningplace=\'commended\',1, 0 ) ) )) as points, winningplace, entrant_id')
                ->whereIn('winningplace', ['1', '2', '3', 'commended'])
                ->where('show_id', $show->id)
                ->orderBy('winningplace', 'asc')
                ->get();

            $winnerDataByCategory[$category->id] = [];
            foreach ($resultset as $categoryWinners) {
                $winnerDataByCategory[$category->id][$categoryWinners->winningplace] =
                    [
                        'entrant' => $categoryWinners->entrant_id,
                        'place' => $categoryWinners->winningplace,
                        'points' => $categoryWinners->points
                    ];
                if (!array_key_exists($categoryWinners->entrant_id, $winners)) {
                    $winners[$categoryWinners->entrant_id] = Entrant::find($categoryWinners->entrant_id);
                }
            }
        }

        $people = [];
        if (Auth::user() && Auth::user()->can('storeResults', $show)) {
            $people = Entrant::whereHas('entries', function (Builder $query) use ($show) {
                $query->where('show_id', $show->id);
            })
                ->orderBy('family_name')
                ->orderBy('first_name')
                ->get()
                ->pluck('full_name', 'id')
                ->toArray();

        }

        return view('cups.show', [
            'cup' => $cup,
            'winners' => $winners,
            'winners_by_category' => $winnerDataByCategory,
            'categories' => $categories->pluck('numbered_name', 'id')->toArray(),
            'people' => $people,
            'isAdmin' => Auth::check() && Auth::User()->isAdmin(),
            'show' => $show,
        ]);
    }

    public function printableresults(Request $request)
    {
        $show = $this->getShowFromRequest($request);
        $showAddress = $request->has('show_address') || $request->has('showaddress') || $request->has('showAddress');
        $winners = array();
        $results = array();
        $cups = Cup::orderBy('sort_order', 'asc')->get();

        /** dragons here - copied from index*/
        foreach ($cups as $cup) {
            $resultset = $cup->getWinningResults($show);

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
            $cupWinner = CupDirectWinner::where('cup_id', $cup->id)->where('show_id', $show->id)->first();
            if ($cupWinner instanceof CupDirectWinner) {
                if (!array_key_exists($cupWinner->entrant_id, $winners)) {
                    $winners[$cupWinner->entrant_id] = ['entrant' => Entrant::find($cupWinner->entrant_id), 'points' => 0];
                }
                $winningCategory = Category::where('id', $cupWinner->winning_category_id)->where('show_id', $show)->first();
            }

            $results[$cup->id] = array('results' => $thisCupPoints,
                                       'direct_winner' => (($cupWinner instanceof CupDirectWinner) ? $cupWinner->entrant_id : null),
                                       'winning_category' => $winningCategory);
        }

        return view('cups.publishablesnippet', ['cups' => $cups,
                                                'results' => $results,
                                                'winners' => $winners,
                                                'show' => $show,
                                                'isAdmin' => Auth::check() && Auth::User()->isAdmin(),
                                                'showAddress' => $showAddress,

        ]);
    }

//        public function storeresults(Request $request) {
//        foreach ($request->positions as $categoryId => $placings) {

    public function directResultPick(Request $request, int $id): View
    {
        $cup = Cup::find($id);
        $entriesObj = Entry::where('category', $request->category)->where('year', config('app.year'))->get();
        $entries = [];
        foreach ($entriesObj as $entry) {
            $entrant = $entry->entrant;
            $entries[$entry->id] = $entrant->full_name;
        }
        return view('cups.directResultPickEntrant', ['entries' => $entries, 'id' => $id, 'thing' => $cup,
                                                     'isAdmin' => Auth::check() && Auth::User()->isAdmin()]);
    }

    public function directResultSetWinner(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $entry = Entry::find($request->entry);
        $cupDirectWinner = new CupDirectWinner();
        $cupDirectWinner->cup = $id;
        $cupDirectWinner->winning_entry_id = $entry->id;
        $cupDirectWinner->year = config('app.year');
        $cupDirectWinner->entrant_id = $entry->entrant_id;
        $cupDirectWinner->winning_category_id = $entry->category_id;
        $cupDirectWinner->save();

        return redirect('/cups/' . $id);
    }

    public function directResultSetWinnerPerson(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $cupDirectWinner = new CupDirectWinner();
        $cupDirectWinner->cup_id = $id;
        $cupDirectWinner->year = config('app.year');
        $cupDirectWinner->entrant_id = $request->person;
        $cupDirectWinner->save();

        return redirect('/cups/' . $id);
    }
}
