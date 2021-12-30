<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Entrant;
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
    /**
     * @var mixed[]
     */
    protected $paymentTypes = array('cash' => 'cash',
                                          'cheque' => 'cheque',
                                          'online' => 'online',
                                          'debit' => 'debit',
                                          'refund_cash' => 'refund_cash',
                                          'refund_online' => 'refund_online',
                                          'refund_cheque' => 'refund_cheque');
    /**
     * @var mixed[]
     */
    protected $membershipTypes = array(
        'single' => 'single',
        'family' => 'family');

    public function isAdmin(): bool
    {
        return Auth::check() && Auth::User()->isAdmin();
    }

    public function subscribe()
    {
        return view(
            'users.subscribe',
            [
                'thing' => Auth::User(),
                'api_key' => config('stripe.api_key_publishable')
            ]
        );
    }

    /**
     * Display a listing of the users
     *
     * @param User|null $user
     * @param Show|null $show
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Request $request, User $user = null): View
    {
        if (is_null($user)) {
            $user = Auth::user();
        }

        $user->load(['entrants', 'entrants.entries']);
        /**
         * Default show
         */
        $show = $this->getShowFromRequest($request);

        $this->authorize('view', $user);
        $membershipFee = 0;
        $entryFee = 0;
        $totalPaid = 0;

        $entryFee = $user->entrants->reduce(
            function (?int $price, Entrant $entrant) use ($show) {
                return ($price ?? 0) + $entrant->entries()
                        ->where('show_id', $show->id)
                        ->get()
                        ->reduce(
                            function ($price, \App\Models\Entry $entry): int {
                                return ($price ?? 0) + $entry->getActualPrice();
                            }
                        );
            }
        );

        $payments = $user->payments()->where('show_id', $show->id)->get();
        foreach ($payments as $payment) {
            $totalPaid += $payment->amount;
        }
//        $memberNumber = $user->getMemberNumber();
        $memberships = $user->membershipPurchases()
            ->where('end_date', '<', Carbon::now())
            ->get();
        foreach ($memberships as $membership) {
            $membershipFee += $membership->amount;
        }
//dump( (new \App\Http\Resources\UserResource($user))->toArray(new Request()));
        //@todo centralise this
        $tooLateForEntries = Carbon::now() > $show->entries_closed_deadline;
//        dd((new \App\Http\Resources\UserResource($user))->toArray(new Request(['show'=>$show->id])));
        return view('users.show', [
            'user' => (new \App\Http\Resources\UserResource($user))->toArray(new Request(['show' => $show])),
            //            'user' => $user,
            'paid' => $totalPaid,
            'membership_fee' => $membershipFee,
            'entry_fee' => $entryFee,
            'total_paid' => $totalPaid,
            'payments' => $payments,
//            'payment_methods' => $user->paymentMethods(),
//            'needs_payment_method' => !$user->hasPaymentMethod(),
            'isAdmin' => $this->isAdmin(),
            'show' => $show,
            'showId' => $show->id,
//            'payment_intent' => $user->hasPaymentMethod() ? null : $user->createSetupIntent(),
            'payment_types' => $this->paymentTypes,
            'membership_types' => [MembershipPurchase::TYPE_FAMILY => 'Family'],
            'has_family_subscription' => false,//$hasFamilySubscription,
            'isLocked' => config('app.state') == 'locked',
            'too_late_for_entries' => $tooLateForEntries,
        ]);
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): View
    {
        $this->authorize('create', User::class);
        return view('users.create', ['privacyContent' => config('static_content.privacy_content')]);
    }

    /**
     * Store a newly created user in storage
     *
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
        /** @var User $user */
        $user = User::create(
            $request->merge(
                [
                    'password_reset_token' => '',
                    'password' => $newPassword,
                    'auth_token' => md5((string) random_int(PHP_INT_MIN, PHP_INT_MAX))]
            )->all()
        );
        $user->makeDefaultEntrant();

        if ($request->has('another')) {
            return redirect()->route('users.create')
                ->withStatus(__('Family :Family successfully created.', ['family' => $user->last_name]));

        }
        return redirect()->route('users.show', ['user' => $user])->withStatus(__('Family successfully created.'));
    }

    /**
     * Show the form for editing the specified user
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $user->update(
            $request->merge(['password' => Hash::make($request->get('password'))])
                ->except([$request->get('password') ? '' : 'password'])
        );

        return redirect()->route('users.index')->withStatus(__('Family successfully updated.'));
    }

    /**
     * Remove the specified user from storage
     *
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();

        return redirect()->route('users.index')->withStatus(__('Family successfully deleted.'));
    }
}
