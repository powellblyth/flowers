<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Entrant;
use App\Models\Entry;
use App\Models\MembershipPurchase;
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
        $show = $this->getShowFromRequest($request);
        $entrant = new Entrant();
        $entrant->firstname = $request->firstname;
        $entrant->familyname = $request->familyname;
        $entrant->membernumber = $request->membernumber;
//        dd('TODO relate to team');
        $entrant->age = $request->age;

        $entrant->can_retain_data = (bool) $request->can_retain_data;

        if ($entrant->save()) {
            $request->session()->flash('success', 'Family Member Saved');

            $entrant->teams()->save(Team::findOrFail($request->team_id), ['show_id' => $show->id]);

            Auth::User()->entrants()->save($entrant);
            return redirect()->route('home');
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
//            $teamMembership = $entrant->teams()->delete(['show_id' => $showId]);
            $entrant->teams()->save($team, ['show_id' => $showId]);
        } else {
            //TODO how do we delete them?
//            $entrant->teams()->pivot->where('show_id', $showId)->delete();
        }


        $entrant->can_retain_data = (int) $request->can_retain_data;

        if ($entrant->save()) {
            $request->session()->flash('success', 'Family Member Saved');
            return redirect()->route('home');
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
            /**
             * @var MembershipPurchase $membershipPurchase
             */
            $amount = (($membershipPurchase->type == 'single' ? 300 : 500));
            $membershipFee += $amount;
            $membershipPaymentData[] = ['type' => $membershipPurchase->type, 'amount' => $amount];
        }

        $entries = $entrant->entries()->where('show_id', $show->id)->with('category')->get();

        foreach ($entries as $entry) {
            /**
             * @var Entry $entry
             */
            if ($entry->category instanceof Category) {
                $price = $entry->category->getPrice($entry->category->getPriceType());

                $entryFee += $price;

                if ($entry->hasWon()) {
                    $totalPrizes += $entry->category->getWinningAmount($entry->winningplace);
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

    /**
     * Show the form for editing the specified resource.
     *
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
