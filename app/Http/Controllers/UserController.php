<?php

namespace App\Http\Controllers;

use App\Entrant;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use \Illuminate\View\View;

class UserController extends Controller {
    protected $templateDir = 'users';
    protected $baseClass = 'App\User';
    protected $paymentTypes = array('cash' => 'cash',
        'cheque' => 'cheque',
        'online' => 'online',
        'debit' => 'debit',
        'refund_cash' => 'refund_cash',
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
    public function index(User $model): View {
        return view('users.index', ['users' => $model::orderBy('lastname')->where('is_anonymised', false)->orderBy('firstname')->get()]);
    }

    public function isAdmin(): bool {
        return Auth::check() && Auth::User()->isAdmin();
    }

    /**
     * Display a listing of the users
     *
     * @param \App\User $model
     * @return \Illuminate\View\View
     */
    public function show(int $id): View {
        $thing = User::find($id);
        $totalPaid = 0;
        $membershipFee = 0;
        $entryFee = 0;
        $totalPaid = 0;

        $currentYear = env('CURRENT_YEAR', 2018);
        foreach ($thing->entrants as $entrant) {

            $entries = $entrant->entries()->where('year', $currentYear)->get();
            foreach ($entries as $entry) {
                $price = $entry->category->getPrice($entry->getPriceType());
                $entryFee += $price;
            }
        }

        $payments = $thing->payments()->where('year', $currentYear)->get();
        foreach ($payments as $payment) {
            $totalPaid += $payment->amount;
        }

        $memberNumber = $thing->getMemberNumber();
        $memberships = $thing->memberships()->where('year', $currentYear)->get();
        foreach ($memberships as $membership) {
            $membershipFee += $membership->amount;
        }
//var_dump([$currentYear,     $membershipFee]);die();
        return view('users.show', [
            'thing' => $thing,
            'paid' => $totalPaid,
            'membership_fee' => $membershipFee,
            'entry_fee' => $entryFee,
            'member_number' => $memberNumber,
            'total_paid' => $totalPaid,
            'payments' => $payments,
            'membership_purchases' => $memberships,
            'isAdmin' => $this->isAdmin(),
            'payment_types' => $this->paymentTypes,
            'membership_types' =>['family'=>'Family'],

        ]);
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create(array $extraData = []): View {
        return view('users.create', ['privacyContent' => config('static_content.privacy_content')]);
    }

    function printcards($id) {
        $categoryData = [];
        $thing = $this->baseClass::find($id);
//var_dump($thing->entrants);die();
        $entrants = $thing->entrants;
        foreach ($entrants as $entrant) {
            $entries = $entrant->entries()->where('year', env('CURRENT_YEAR', 2018))->get();
            $cardFronts = [];
            $cardBacks = [];

            foreach ($entries as $entry) {
                if ($entry->category) {
                    $categoryData[$entry->category->id] = $entry->category;
                    $cardFronts[] = $entry->getCardFrontData();
                    $cardBacks[] = $entry->getCardBackData();
                }
            }
        }
        return view('cards.printcards', [
            'card_fronts' => $cardFronts,
            'card_backs' => $cardBacks,
        ]);
    }

    /**
     * Store a newly created user in storage
     *
     * @param \App\Http\Requests\UserRequest $request
     * @param \App\User $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request, User $model) {
        if (empty($request->get('password'))) {
            $newPassword = '';
        } else {
            $newPassword = Hash::make($request->get('password'));
        }
        $user = $model->create($request->merge(
            [
                'password_reset_token' => '',
                'password' => $newPassword,
                'auth_token' => md5(random_int(PHP_INT_MIN, PHP_INT_MAX))])->all());
        $user->makeDefaultEntrant();

        return redirect()->route('user.index')->withStatus(__('User successfully created.'));
    }

    /**
     * Show the form for editing the specified user
     *
     * @param \App\User $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user) {
        return view('users.edit', array_merge(compact('user'), ['privacyContent' => config('static_content.privacy_content')]));
    }

    /**
     * Update the specified user in storage
     *
     * @param \App\Http\Requests\UserRequest $request
     * @param \App\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User $user) {
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
    public function destroy(User $user) {
        $user->delete();

        return redirect()->route('user.index')->withStatus(__('User successfully deleted.'));
    }
}
