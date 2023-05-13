<?php

namespace App\Http\Controllers;

use App\Http\Requests\EntrantRequest;
use App\Models\Entrant;
use App\Models\Entry;
use App\Models\MembershipPurchase;
use App\Models\Show;
use App\Models\Team;
use App\Traits\Controllers\HasShowSwitcher;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EntrantController extends Controller
{
    use HasShowSwitcher;

    /** @var array */
    protected array $paymentTypes = array('cash' => 'cash',
                                          'cheque' => 'cheque',
                                          'online' => 'online',
                                          'debit' => 'debit',
                                          'refund_cash' => 'refund_cash',
                                          'refund_online' => 'refund_online',
                                          'refund_cheque' => 'refund_cheque');

    protected array $membershipTypes = array(
        'single' => 'single',
        'family' => 'family');

    /**
     * @throws AuthorizationException
     */
    public function create(Request $request): View
    {
        $user = Auth::user();
        $this->authorize('addEntrant', $user);

        $allTeams = Team::where('status', 'active')
            ->orderBy('min_age')
            ->orderBy('max_age')
            ->orderBy('name')
            ->get()
            ->pluck('name', 'id')->toArray();
        return view('entrants.edit', [
            'privacyContent' => config('static_content.privacy_content'),
            'teams' => $allTeams,
            'entrant' => new Entrant(),
            'defaultFamilyName' => $user->last_name,
        ]);
    }

    public function store(EntrantRequest $request): RedirectResponse
    {
        $entrant = Entrant::create(
            $request->validated(null, null)
            + [
                'user_id' => auth()->id(),
            ]
        );

        if (is_numeric($request->team_id)) {
            $show = $this->getShowFromRequest($request);
            $entrant->teams()->save(Team::findOrFail($request->team_id), ['show_id' => $show->id]);
        }

        if ($entrant->save()) {
            $request->session()->flash('success', 'Family Member Saved');


            Auth::User()->entrants()->save($entrant);
            return redirect()->route('family');
        } else {
            $request->session()->flash('error', 'Something went wrong saving the Family Member');
            return back();
        }
    }

    /**
     * @throws AuthorizationException
     */
    public function update(EntrantRequest $request, Entrant $entrant): RedirectResponse
    {
        $this->authorize('update', $entrant);

        $entrant->update($request->validated(null, null));

        // No point eding
        $showId = Show::where('status', 'current')->first()->id;

        // Make sure we don't make duplicate show entries in a given year
        if ($request->team_id) {
            $team = Team::findOrFail($request->team_id);
            $entrant->teams()->save($team, ['show_id' => $showId]);
        } else {
            //TODO how do we delete them?
//            $entrant->teams()->pivot->where('show_id', $showId)->delete();
        }

        if ($entrant->save()) {
            $request->session()->flash('success', 'Family Member Saved');
            return redirect()->route('family');
        } else {
            $request->session()->flash('error', 'Something went wrong saving the Family Member');
            return back();
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
     * @throws Exception
     */
    public function show(Request $request, Entrant $entrant, array $showData = []): Response
    {
        $totalPrizes = 0;
        $membershipFee = 0;
        $entryFee = 0;

        $show = $this->getShowFromRequest($request);

        $this->authorize('seeDetailedInfo', $entrant);

        $categories = $show->categories()->orderBy('sortorder')
            ->where('status', 'active')
            ->get();

        $membershipPurchases = $entrant->membershipPurchases()->get();
        $membershipPaymentData = [];
        foreach ($membershipPurchases as $membershipPurchase) {
            /** @var MembershipPurchase $membershipPurchase */
            $amount = (($membershipPurchase->type == 'single' ? 300 : 500));
            $membershipFee += $amount;
            $membershipPaymentData[] = ['type' => $membershipPurchase->type, 'amount' => $amount];
        }

        $entries = $entrant->entries()->where('show_id', $show->id)->with('category')->get();

        foreach ($entries as $entry) {
            /** @var Entry $entry */
            $price = $entry->category->getPrice($entry->getPriceType());
            $entryFee += $price;
            if ($entry->hasWon()) {
                $totalPrizes += $entry->category->getWinningAmount($entry->winningplace);
            }
        }
        $memberNumber = $entrant->getMemberNumber() ?? 'Not currently a member';

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
                    'entrant' => $entrant,
                    'member_number' => $memberNumber,
                    'isLocked' => config('app.state') == 'locked',
                ]
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     * @throws AuthorizationException
     */
    public function edit(Entrant $entrant): \Illuminate\Contracts\View\View|Factory|Application
    {
        $this->authorize('update', $entrant);

        return view(
            'entrants.edit',
            [
                'entrant' => $entrant,
                'teams' => $entrant->getValidTeamOptions(),
                'privacyContent' => config('static_content.privacy_content'),
            ]
        );
    }
}
