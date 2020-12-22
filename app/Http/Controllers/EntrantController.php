<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Entrant;
use App\Models\Entry;
use App\Models\Show;
use App\Models\Team;
use App\Models\TeamMembership;
use App\Models\User;
use DB;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EntrantController extends Controller
{
    protected array $paymentTypes = array('cash' => 'cash',
                                          'cheque' => 'cheque',
                                          'online' => 'online',
                                          'debit' => 'debit',
                                          'refund_cash' => 'refund_cash',
                                          'refund_online' => 'refund_online',
                                          'refund_cheque' => 'refund_cheque');

    protected $membershipTypes = array(
        'single' => 'single',
        'family' => 'family');

    public function isAdmin(): bool
    {
        return Auth::check() && Auth::User()->isAdmin();
    }

    public function index(Request $request): View
    {
        $entrants = Entrant::with('user')
            ->where('is_anonymised', false)
            ->orderBy('familyname')
            ->orderBy('user_id')
            ->orderBy('firstname')
            ->get();
        // OVerride parent method - this prevents the same query running twice
        // and producing too much data
        return view(
            'entrants.index',
            [
                'entrants' => $entrants,
                'all' => false,
                'isLocked' => config('app.state') == 'locked',
            ]
        );
    }

    public function search(Request $request): View
    {
        $searchTerm = $request->input('searchterm');
        $entrantsBuilder = Auth::User()->entrants();
        if ($request->has('searchterm')) {
            $entrantsBuilder = $entrantsBuilder
                ->whereRaw("(entrants.firstname LIKE '%$searchTerm%' OR entrants.familyname LIKE '%$searchTerm%' OR entrants.id = '%$searchTerm%') ");
        }

        $entrants = $entrantsBuilder->orderBy('familyname', 'asc')
            ->orderBy('firstname', 'asc')
            ->get();

        return view(
            'entrants.index',
            [
                'things' => $entrants,
                'searchterm' => $searchTerm,
                'all' => false,
            ]
        );
    }

    public function searchAll(Request $request): View
    {
        $searchterm = null;
        if ($request->has('searchterm')) {
            $searchterm = $request->input('searchterm');
            $entrants = Entrant::where('entrants.firstname', 'LIKE', "%$searchterm%")
                ->orWhere('entrants.familyname', 'LIKE', "%$searchterm%")
                ->orWhere('entrants.id', '=', "%$searchterm%")
                ->get();
        } else {
            $entrants = Entrant::where('is_anonymised', false)
                ->with('user')
                ->orderBy('familyname', 'asc')
                ->orderBy('firstname', 'asc')
                ->get();
        }
        return view(
            'entrants.index',
            [
                'entrants' => $entrants,
                'searchterm' => $searchterm,
                'all' => true,
                'isAdmin' => $this->isAdmin(),
                'isLocked' => config('app.state') == 'locked',
            ]
        );
    }

    public function create(Request $request, ?int $family = null): View
    {
        if ($family) {
            $family = User::findOrFail($family);
        } else {
            $family = Auth::user();
        }
        $this->authorize('addEntrant', $family);
        $indicatedAdmin = null;

        $allUsers = collect($family);

        if (Auth::user()->can('viewAny', User::class)) {
            $allUsers = User::Select(DB::raw('id, concat(lastname, \', \', firstname) as the_name'))
                ->where('is_anonymised', false)
                ->orderBy('lastname', 'asc')
                ->orderBy('firstname')
                ->pluck('the_name', 'id');
        }

        $allTeams = Team::where('status', 'active')
            ->orderBy('min_age')
            ->orderBy('max_age')
            ->orderBy('name')
            ->get()
            ->pluck('name', 'id')->toArray();

        return view('entrants.create', [
            'privacyContent' => config('static_content.privacy_content'),
            'allUsers' => $allUsers,
            'teams' => $allTeams,
            'indicatedAdmin' => $family->id,
            'defaultFamilyName' => $family->lastname,
        ]);
    }

    public function store(Request $request)
    {
        // Validate the request...

        $entrant = new Entrant();

        $entrant->firstname = $request->firstname;
        $entrant->familyname = $request->familyname;
        $entrant->membernumber = $request->membernumber;
        $entrant->team_id = $request->team_id;
        dd('TODO relate to team');
        $entrant->age = $request->age;

        $entrant->can_retain_data = (int) $request->can_retain_data;

        if ($entrant->save()) {
            $request->session()->flash('success', 'Family Member Saved');
            if (!$this->isAdmin()) {
                Auth::User()->entrants()->save($entrant);
                return redirect()->route('user.family');
            } elseif ($request->has('user_id')) {
                $user = User::find((int) $request->user_id);
                $user->entrants()->save($entrant);
                return redirect()->route('entrants.index');
            }
        } else {
            $request->session()->flash('error', 'Something went wrong saving the Family Member');
            return back();
        }
    }

    public function update(Request $request, Entrant $entrant)
    {
//        $entrant = Entrant::where('id', $request->id)->firstOrFail();
        $this->authorize('update', $entrant);
        $age = (int) $request->age;
        $request->validate(
            [
                'firstname' => 'string|required|min:1',
                'familyname' => 'string|required|min:1',
                'age' => 'integer|nullable|min:0|',
                'team_id' => ['nullable',
                              'integer',
                              Rule::exists('teams', 'id')->where(function ($query) use ($age) {
                                  $query
                                      ->where('min_age', '<=', $age)
                                      ->where('max_age', '>=', $age);
                                  return $query;
                              })],
            ]
        );
        $entrant->firstname = $request->firstname;
        $entrant->familyname = $request->familyname;
        $entrant->membernumber = $request->membernumber;
        // No point eding
        $showId = Show::where('status', 'current')->first()->id;

        $entrant->age = $request->age;

        // Make sure we don't make duplicate show entries in a given year
        if ($request->team_id) {
            $team = Team::findOrFail($request->team_id);
            $teamMembership = TeamMembership::firstOrNew(['show_id' => $showId, 'entrant_id' => $entrant->id]);
            $teamMembership->team()->associate($team);
            $teamMembership->save();
        } else {
            $entrant->team_memberships()->where('show_id', $showId)->delete();
        }


        $entrant->can_retain_data = (int) $request->can_retain_data;
        $entrant->can_email = (int) $request->can_email;
        $entrant->can_sms = (int) $request->can_sms;
        $entrant->can_post = (int) $request->can_post;

        if ($entrant->save()) {
            $request->session()->flash('success', 'Family Member Saved');
            if ($this->isAdmin()) {
                return redirect()->route('entrants.index');
            } else {
                return redirect()->route('user.family');
            }
        } else {
            $request->session()->flash('error', 'Something went wrong saving the Family Member');
            return back();
        }
    }


    public function changeCategories(Request $request, int $id)
    {
        if ($request->isMethod('POST')) {
            return redirect()->route('entrants.index');
        } else {
            $entrant = Entrant::where('id', $id)->firstOrFail();
            die();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Entrant $entrant
     * @param array $showData
     * @return Response
     * @throws AuthorizationException
     */
    public function show(Request $request, Entrant $entrant, array $showData = [])
    {
        $totalPrizes = 0;
        $membershipFee = 0;
        $entryFee = 0;

        $show = $this->getShowFromRequest($request);
        $currentYear = config('app.year');

        $this->authorize('seeDetailedInfo', $entrant);

        $categories = $show->categories()->orderBy('sortorder')
            ->where('status', 'active')
            ->get();

        $membershipPurchases = $entrant->membershipPurchases()->get();
        $membershipPaymentData = [];
        foreach ($membershipPurchases as $membershipPurchase) {
            $amount = (($membershipPurchase->type == 'single' ? 300 : 500));
            $membershipFee += $amount;
            $membershipPaymentData[] = ['type' => $membershipPurchase->type, 'amount' => $amount];
        }

        $entries = $entrant->entries()->where('show_id', $show->id)->with('category')->get();

        foreach ($entries as $entry) {
            if ($entry->category instanceof Category) {
                // Hydrate
                $category = $entry->category;

                $price = $category->getPrice($entry->getPriceType());

                $entryFee += $price;

                if ($entry->hasWon()) {
                    $totalPrizes += $category->getWinningAmount($entry->winningplace);
                }
            }

        }
        $memberNumber = $entrant->getMemberNumber() ?? 'Not currently a member';

        //@todo centralise this
        $tooLateForEntries = time() > strToTime($currentYear . "-07-09 00:00:00");

        return response()->view(
            'entrants.show',
            array_merge(
                $showData,
                [
                    'entries' => $entries,
                    'categories' => $categories,
                    'membership_purchases' => $membershipPaymentData,
                    'entry_fee' => $entryFee,
                    'total_price' => $entryFee + $membershipFee,
                    'payment_types' => $this->paymentTypes,
                    'total_prizes' => $totalPrizes,
                    'membership_types' => ['single' => 'Single'],
                    'thing' => $entrant,
                    'member_number' => $memberNumber,
                    'isLocked' => config('app.state') == 'locked',
                    'too_late_for_entries' => $tooLateForEntries,
                ]
            )
        );
    }

    public function printcards($id)
    {
        $categoryData = [];
        $entrant = Entrant::findOrFail($id);
        $entries = $entrant->entries()->where('year', config('app.year'))->get();
        $cardFronts = [];
        $cardBacks = [];

        foreach ($entries as $entry) {
            if ($entry->category) {
                /**
                 * @var Entry $entry
                 */
                $categoryData[$entry->category->id] = $entry->category;
                $cardFronts[] = $entry->getCardFrontData();
                $cardBacks[] = $entry->getCardBackData();
            }
        }

        return view('cards.printcards', [
            'card_fronts' => $cardFronts,
            'card_backs' => $cardBacks,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Entrant $entrant
     * @return Response
     * @throws AuthorizationException
     */
    public function edit(Entrant $entrant)
    {
        $this->authorize('update', $entrant);

        return view('entrants.edit', array(
            'thing' => $entrant,
            'teams' => $entrant->getValidTeamOptions(),
            'privacyContent' => config('static_content.privacy_content'),
            'isAdmin' => $this->isAdmin()));
    }
}
