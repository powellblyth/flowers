<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\MembershipPurchase;
use App\Models\Show;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    protected $paymentTypes    = array('cash'          => 'cash',
                                       'cheque'        => 'cheque',
                                       'online'        => 'online',
                                       'debit'         => 'debit',
                                       'refund_cash'   => 'refund_cash',
                                       'refund_online' => 'refund_online',
                                       'refund_cheque' => 'refund_cheque');
    protected $membershipTypes = array(
        'single' => 'single',
        'family' => 'family');


    /**
     * Display a listing of the users
     *
     * @param User $model
     * @return \Illuminate\View\View
     */
    public function index(User $model): View
    {
        return view('users.index', [
            'users'    => $model::where('is_anonymised', false)
                ->with('entrants')
                ->withCount('entrants')
                ->orderBy('lastname')
                ->orderBy('firstname')
                ->get(),
            'isLocked' => config('app.state') == 'locked',
        ]);
    }

    public function isAdmin(): bool
    {
        return Auth::check() && Auth::User()->isAdmin();
    }

    public function subscribe(Request $request)
    {
        return view(
            'users.subscribe',
            [
                'thing'   => Auth::User(),
                'api_key' => config('stripe.api_key_publishable')
            ]
        );
    }

    /**
     * Display a listing of the users
     *
     * @param User|null $user
     * @param Show|null $show
     * @return \Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(User $user = null, Show $show = null): View
    {
        if (is_null($user)) {
            $user = Auth::user();
        }
        /**
         * Default show
         */
        if (is_null($show)) {
            $show = Show::where('status', 'current')->first();
        }

        $this->authorize('view', $user);
        $membershipFee = 0;
        $entryFee      = 0;
        $totalPaid     = 0;

        foreach ($user->entrants as $entrant) {
            $entries = $entrant->entries()->with(['show','category'])->where('show_id', $show->id)->get();
            foreach ($entries as $entry) {
                $price    = $entry->category->getPrice($entry->getPriceType());
                $entryFee += $price;
            }
        }

        $payments = $user->payments()->where('show_id', $show->id)->get();
        foreach ($payments as $payment) {
            $totalPaid += $payment->amount;
        }

        $memberNumber = $user->getMemberNumber();
        $memberships  = $user->membership_purchases()
            ->where('end_date', '<', Carbon::now())
            ->get();
        foreach ($memberships as $membership) {
            $membershipFee += $membership->amount;
        }

        //@todo centralise this
        $tooLateForEntries = Carbon::now() > $show->entries_closed_deadline;

        return view('users.show', [
            'thing'                   => $user,
            'paid'                    => $totalPaid,
            'membership_fee'          => $membershipFee,
            'entry_fee'               => $entryFee,
            'total_paid'              => $totalPaid,
            'payments'                => $payments,
            'isAdmin'                 => $this->isAdmin(),
            'showId'                  => $show->id,
            'payment_types'           => $this->paymentTypes,
            'membership_types'        => [MembershipPurchase::TYPE_FAMILY => 'Family'],
            'has_family_subscription' => false,//$hasFamilySubscription,
            'isLocked'                => config('app.state') == 'locked',
            'too_late_for_entries'    => $tooLateForEntries,
        ]);
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create(array $extraData = []): View
    {
        $this->authorize('create', User::class);
        return view('users.create', ['privacyContent' => config('static_content.privacy_content')]);
    }

    function printcards($id)
    {
        $categoryData = [];
        $thing        = User::find($id);
        $entrants     = $thing->entrants;
        $cardFronts   = [];
        $cardBacks    = [];
        foreach ($entrants as $entrant) {
            $entries = $entrant->entries()->where('year', config('app.year'))->get();

            foreach ($entries as $entry) {
                if ($entry->category) {
                    $categoryData[$entry->category->id] = $entry->category;
                    $cardFronts[]                       = $entry->getCardFrontData();
                    $cardBacks[]                        = $entry->getCardBackData();
                }
            }
        }
        return view('cards.printcards', [
            'card_fronts' => $cardFronts,
            'card_backs'  => $cardBacks,
        ]);
    }

    /**
     * Store a newly created user in storage
     *
     * @param UserRequest $request
     * @param User $model
     * @return RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $this->authorize('update', User::class);
        if (empty($request->get('password'))) {
            $newPassword = '';
        } else {
            $newPassword = Hash::make($request->get('password'));
        }
        $user = User::create(
            $request->merge(
                [
                    'password_reset_token' => '',
                    'password'             => $newPassword,
                    'auth_token'           => md5((string) random_int(PHP_INT_MIN, PHP_INT_MAX))]
            )->all()
        );
        $user->makeDefaultEntrant();

        if ($request->has('another')) {

            return redirect()->route('users.create')
                ->withStatus(__('Family :Family successfully created.', ['family' => $user->lastname]));

        }
        return redirect()->route('users.show', ['user' => $user])->withStatus(__('Family successfully created.'));
    }

    /**
     * Show the form for editing the specified user
     *
     * @param User $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view(
            'users.edit',
            array_merge(
                compact('user'),
                ['privacyContent' => config('static_content.privacy_content')]
            )
        );
    }

    /**
     * Update the specified user in storage
     *
     * @param UserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $user->update(
            $request->merge(['password' => Hash::make($request->get('password'))])
                ->except([$request->get('password') ? '' : 'password']
                ));

        return redirect()->route('users.index')->withStatus(__('Family successfully updated.'));
    }

    /**
     * Remove the specified user from storage
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();

        return redirect()->route('users.index')->withStatus(__('Family successfully deleted.'));
    }
}
