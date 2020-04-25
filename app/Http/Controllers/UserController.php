<?php

namespace App\Http\Controllers;

use App\Entrant;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use \Illuminate\View\View;

class UserController extends Controller
{
    protected $templateDir     = 'users';
    protected $baseClass       = 'App\User';
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
     * @param \App\User $model
     * @return \Illuminate\View\View
     */
    public function index(User $model): View
    {
        return view('users.index', [
            'users'    => $model::where('is_anonymised', false)
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
        return view('users.subscribe',
            [
                'thing'   => Auth::User(),
                'api_key' => config('stripe.api_key_publishable')
            ]
        );
    }

    /**
     * Display a listing of the users
     *
     * @param \App\User $model
     * @return \Illuminate\View\View
     */
    public function family(int $id = null): View
    {
        if (is_null($id)) {
            $id = Auth::user()->id;
        }
        $thing         = User::find($id);
        $membershipFee = 0;
        $entryFee      = 0;
        $totalPaid     = 0;
        if ($thing instanceof User) {

            $currentYear = config('app.year');
//            var_dump($thing->entrants);die();
            foreach ($thing->entrants as $entrant) {

                $entries = $entrant->entries()->where('year', $currentYear)->get();
                foreach ($entries as $entry) {
                    $price    = $entry->category->getPrice($entry->getPriceType());
                    $entryFee += $price;
                }
            }

            $payments = $thing->payments()->where('year', $currentYear)->get();
            foreach ($payments as $payment) {
                $totalPaid += $payment->amount;
            }

            $memberNumber = $thing->getMemberNumber();
            $memberships  = $thing->memberships()->where('year', $currentYear)->get();
            foreach ($memberships as $membership) {
                $membershipFee += $membership->amount;
            }

            //@todo centralise this
            $tooLateForEntries = time() > strToTime($currentYear . "-07-09 00:00:00");

//            $hasFamilySubscription = $thing->subscribed('family');
//var_dump([$currentYear,     $membershipFee]);die();
            return view('users.show', [
                'thing'                   => $thing,
                'paid'                    => $totalPaid,
                'membership_fee'          => $membershipFee,
                'entry_fee'               => $entryFee,
                'total_paid'              => $totalPaid,
                'payments'                => $payments,
                'membership_purchases'    => $memberships,
                'isAdmin'                 => $this->isAdmin(),
                'payment_types'           => $this->paymentTypes,
                'membership_types'        => ['family' => 'Family'],
                'has_family_subscription' => false ,//$hasFamilySubscription,
                'isLocked'                => config('app.state') == 'locked',
                'too_late_for_entries'    => $tooLateForEntries,
            ]);
        } else {
            return view('404');
        }
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create(array $extraData = []): View
    {
        return view('users.create', ['privacyContent' => config('static_content.privacy_content')]);
    }

    function printcards($id)
    {
        $categoryData = [];
        $thing        = User::find($id);
//var_dump($thing->entrants);die();
        $entrants   = $thing->entrants;
        $cardFronts = [];
        $cardBacks  = [];
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
     * @param \App\Http\Requests\UserRequest $request
     * @param \App\User $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request, User $model)
    {
        $this->authorize('update', $model);
        if (empty($request->get('password'))) {
            $newPassword = '';
        } else {
            $newPassword = Hash::make($request->get('password'));
        }
        $user = $model->create($request->merge(
            [
                'password_reset_token' => '',
                'password'             => $newPassword,
                'auth_token'           => md5((string) random_int(PHP_INT_MIN, PHP_INT_MAX))])->all());
        $user->makeDefaultEntrant();

        return redirect()->route('user.index')->withStatus(__('User successfully created.'));
    }

    /**
     * Show the form for editing the specified user
     *
     * @param \App\User $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', array_merge(compact('user'), ['privacyContent' => config('static_content.privacy_content')]));
    }

    /**
     * Update the specified user in storage
     *
     * @param \App\Http\Requests\UserRequest $request
     * @param \App\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $user->update(
            $request->merge(['password' => Hash::make($request->get('password'))])
                ->except([$request->get('password') ? '' : 'password']
                ));

        return redirect()->route('user.index')->withStatus(__('User successfully updated.'));
    }

    /**
     * Remove the specified user from storage
     *
     * @param \App\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();

        return redirect()->route('user.index')->withStatus(__('User successfully deleted.'));
    }
}
