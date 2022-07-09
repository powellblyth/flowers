<?php

namespace App\Http\Controllers;

use App\Models\Cup;
use App\Models\CupDirectWinner;
use App\Models\Entrant;
use App\Models\Entry;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        $cups = Cup::with(['section'])
            ->orderBy('sort_order', 'asc')->get();
        foreach ($cups as $cup) {
            $results[$cup->id] = [];
            /** @var Cup $cup */
            if ($cup->winning_basis === Cup::WINNING_BASIS_TOTAL_POINTS) {
                $resultSet = $cup->getWinningResults($show);
                $thisCupPoints = array();
                foreach ($resultSet as $result) {
                    $thisCupPoints[] = [
                        'firstplacepoints' => $result->firstplacepoints,
                        'secondplacepoints' => $result->secondplacepoints,
                        'thirdplacepoints' => $result->thirdplacepoints,
                        'commendedplacepoints' => $result->commendedplacepoints,
                        'totalpoints' => $result->totalpoints,
                        'entrant' => $result->entrant_id,
                    ];
                    if (!array_key_exists($result->entrant_id, $winners)) {
                        $winners[$result->entrant_id] = [
                            'entrant' => Entrant::find($result->entrant_id),
                            'points' => $result->totalpoints
                        ];
                    }
                }
                $results[$cup->id] = array('results' => $thisCupPoints);
            } else {
                $cupWinner = $cup->cupDirectWinner()->where('show_id', $show->id)->first();
                $winningCategory = null;
                if ($cupWinner instanceof CupDirectWinner) {
                    if ($cupWinner?->winningEntry && !array_key_exists($cupWinner->winningEntry->entrant->id, $winners)) {
                        $winners[$cupWinner->winningEntry->entrant->id] =
                            [
                                'entrant' => $cupWinner->winningEntry->entrant,
                                'points' => 0,
                            ];
                    }
                    $winningEntry = $cupWinner->winningEntry()
                        ->where('show_id', $show->id)
                        ->first();

                    $results[$cup->id] = array('direct_winner' => $winningEntry?->entrant_id,
                                               'winning_entry' => $winningEntry,
                                               'winning_category' => $winningEntry?->category,
                        );
                }
            }


            /** @var CupDirectWinner $cupWinner */
            $cupWinner = $cup->cupDirectWinner()->forShow($show)->first();
        }
        return view('cups.index', ['cups' => $cups,
                                   'results' => $results,
                                   'winners' => $winners,
                                   'show' => $show,
                                   'isAdmin' => Auth::check() && Auth::User()->isAdmin(),
        ]);
    }

    public function categories(Request $request)
    {
        $show = $this->getShowFromRequest($request);
        $cups = Cup::with(['section'])->orderBy('sort_order', 'asc')->get();
        return view(
            'cups.cupcategories',
            [
                'cups' => $cups,
                'show' => $show,
            ]
        );
    }

    public function show(Request $request, Cup $cup): View
    {
//        $cup = Cup::findOrFail($cupId);
        $winnerDataByCategory = [];
        $winners = [];
        $show = $this->getShowFromRequest($request);

        $categories = $cup->relatedCategories($show);

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
            'categories' => $categories,
            'people' => $people,
            'isAdmin' => Auth::check() && Auth::User()->isAdmin(),
            'show' => $show,
        ]);
    }

    public function printableresults(Request $request)
    {
        $show = $this->getShowFromRequest($request);
        $showAddress = $request->has('show_address') || $request->has('showaddress') || $request->has('showAddress');
        $winners = [];
        $results = [];
        $cups = Cup::orderBy('sort_order', 'asc')->get();

        /** dragons here - copied from index*/
        foreach ($cups as $cup) {
            $resultset = $cup->getWinningResults($show);

            $thisCupPoints = [];
            foreach ($resultset as $result) {
                $thisCupPoints[] = ['firstplacepoints' => $result->firstplacepoints,
                                    'secondplacepoints' => $result->secondplacepoints,
                                    'thirdplacepoints' => $result->thirdplacepoints,
                                    'commendedplacepoints' => $result->commendedplacepoints,
                                    'totalpoints' => $result->totalpoints,
                                    'entrant' => $result->entrant_id];
                if (!array_key_exists($result->entrant_id, $winners)) {
                    $winners[$result->entrant_id] = [
                        'entrant' => Entrant::find($result->entrant_id),
                        'points' => $result->totalpoints,
                    ];
                }
            }

            $winningCategory = null;

            // Gather up more winners if needed
            try {
                $cupWinner = $cup->cupDirectWinner()->forShow($show)->firstOrFail();
                if (!array_key_exists($cupWinner->entrant_id, $winners)) {
                    $winners[$cupWinner->entrant_id] = [
                        'entrant' => Entrant::find($cupWinner->entrant_id),
                        'points' => 0,
                    ];
                }
                $winningCategory = $cupWinner->winningCategory()->forShow($show)
                    ->first();
            } catch (ModelNotFoundException) {
                ;
            }

            $results[$cup->id] = array('results' => $thisCupPoints,
                                       'direct_winner' => $cupWinner?->entrant_id,
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

    public function directResultPick(Request $request, int $id): View
    {
        $cup = Cup::find($id);
        $entries = Entry::where('category_id', $request->post('category'))->get();
        $entriesAry = [];
        foreach ($entries as $entry) {
//            dump($entry->id);
            $entrant = $entry->entrant;
            $entriesAry[$entry->id] = $entrant->full_name;
        }
//        dd($request);
        return view('cups.directResultPickEntrant', [
            'entries' => $entriesAry,
            'id' => $id,
            'thing' => $cup,
            'isAdmin' => Auth::check() && Auth::User()->isAdmin()]);
    }

    public function directResultSetWinner(Request $request, Cup $id): \Illuminate\Http\RedirectResponse
    {
        $cup = $id; // No idea jsut wevvs
        $entry = Entry::findOrFail($request->entry);
        $cupDirectWinner = new CupDirectWinner();
        $cupDirectWinner->show()->associate($entry->show);
        $cupDirectWinner->cup()->associate($cup);
        $cupDirectWinner->winningEntry()->associate($entry);
        $cupDirectWinner->winningCategory()->associate($entry->category);
        $cupDirectWinner->save();

        return redirect(route('cups.show', $cup));
    }

    public function directResultSetWinnerPerson(Request $request, Cup $cup): \Illuminate\Http\RedirectResponse
    {
        $cupDirectWinner = new CupDirectWinner();
        $cupDirectWinner->cup()->associate($cup);
        $cupDirectWinner->save();

        return redirect(route('cups.show', $cup));
    }
}
