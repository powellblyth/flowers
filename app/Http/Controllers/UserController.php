<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManualSubscriptionRenewRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\Entrant;
use App\Models\Membership;
use App\Models\MembershipPurchase;
use App\Models\Payment;
use App\Models\Show;
use App\Models\User;
use App\Traits\Controllers\HasShowSwitcher;
use App\Traits\MakesCards;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Throwable;

class UserController extends Controller
{
    use HasShowSwitcher;
    use MakesCards;

    public function isAdmin(): bool
    {
        return Auth::check() && Auth::User()->isAdmin();
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function index(Request $request): RedirectResponse
    {
        $show = $this->getShowFromRequest($request);
        return redirect(route('family.show', ['show' => $show]), 301);
    }

    public function subscribe(): Factory|\Illuminate\Contracts\View\View|Application
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
     * @return \Illuminate\Contracts\View\View
     * @throws AuthorizationException
     */
    public function show(Request $request, Show $show, User $user = null): View
    {
        if (is_null($user)) {
            $user = Auth::user();
        }

        $user->load(['entrants', 'entrants.entries']);

        $this->authorize('view', $user);
        $membershipFee = 0;
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
        $memberships = $user->membershipPurchases()
            ->active()
            ->get();
        foreach ($memberships as $membership) {
            $membershipFee += $membership->amount;
        }

        return view('users.show', [
            'user' => (new UserResource($user))->toArray(new Request(['show' => $show])),
            'paid' => $totalPaid,
            'membership_fee' => $membershipFee,
            'entry_fee' => $entryFee,
            'total_paid' => $totalPaid,
            'payments' => $payments,
            'isAdmin' => $this->isAdmin(),
            'show' => $show,
        ]);
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\Contracts\View\View
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('create', User::class);
        return view('users.create', ['privacyContent' => config('static_content.privacy_content')]);
    }

    /**
     * Show the form for merging a person
     *
     * @return \Illuminate\Contracts\View\View
     * @throws AuthorizationException
     */
    public function merge(User $user): View
    {
        $this->authorize('delete', $user);
        return view('users.merge', ['user' => $user]);
    }

    public function prepareMerge(User $user, User $mergeInto)
    {
        $this->authorize('delete', $user);
        return view('users.prepareMerge', ['user' => $user, 'mergeInto' => $mergeInto]);
    }
    /**
     * Store a newly created user in storage
     *
     * @param UserRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws Exception
     */
    public function store(UserRequest $request): RedirectResponse
    {
        $this->authorize('update', User::class);
        $newPassword = empty($request->get('password')) ? '' : Hash::make($request->get('password'));
        /** @var User $user */
        $user = User::create(
            $request->merge(
                [
                    'password_reset_token' => '',
                    'password' => $newPassword,
                    'auth_token' => md5((string) random_int(PHP_INT_MIN, PHP_INT_MAX))]
            )->all()
        );
        $user->createDefaultEntrant();

        if ($request->has('another')) {
            return redirect()->route('users.create')
                ->withStatus(__('Family :Family successfully created.', ['family' => $user->last_name]));

        }
        return redirect()->route('users.show', ['user' => $user])
            ->withStatus(__('Family successfully created.'));
    }

    /**
     * Show the form for editing the specified user
     *
     * @return \Illuminate\Contracts\View\View
     * @throws AuthorizationException
     */
    public function edit(User $user): \Illuminate\Contracts\View\View
    {
        $this->authorize('update', $user);
        return view(
            'users.edit',
            ['user' => $user, 'privacyContent' => config('static_content.privacy_content')]
        );
    }

    /**
     * Remove the specified user from storage
     *
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);
        $user->delete();

        return redirect()->route('users.index')
            ->withStatus(__('Family successfully deleted.'));
    }

    public function printCards(Request $request, Show $show): Application|Factory|\Illuminate\Contracts\View\View
    {
        $entriesQuery = $this->getEntriesQuery($show);
        $entriesQuery->whereIn('users.id', $request->get('users'));

        if ($request->filled('since')) {
            $entriesQuery->where('entries.updated_at', '>', Carbon::now()->subMinutes((int) $request->since));
        }

        $cardData = $this->getCardDataFromEntries($entriesQuery->get());

        return view('cards.printcards', [
            'card_fronts' => $cardData['fronts'],
            'card_backs' => $cardData['backs'],
        ]);
    }

    public function printCardsA5(Request $request, Show $show): Application|Factory|\Illuminate\Contracts\View\View
    {
        $entriesQuery = $this->getEntriesQuery($show);
        $entriesQuery->whereIn('users.id', $request->get('users'));

        if ($request->filled('since')) {
            $entriesQuery->where('entries.updated_at', '>', Carbon::now()->subMinutes((int) $request->since));
        }

        $cardData = $this->getCardDataFromEntries($entriesQuery->get());

        return view('cards.printcardsA5', [
            'show' => $show,
            'card_fronts' => $cardData['fronts'],
            'card_backs' => $cardData['backs'],
        ]);
    }

    /**
     * @throws AuthorizationException
     * @TODO can I do this in Nova? It seems possible
     */
    public function previousMembersList(): Factory|\Illuminate\Contracts\View\View|Application
    {
        $this->authorize('viewAny', User::class);
        $memberList = User::with('membershipPurchases')->notanonymised()->alphabetical()->get();

        return view('users.memberList', [
            'members' => $memberList,
        ]);
    }


    /**
     * @param ManualSubscriptionRenewRequest $request
     * @param User $user
     * @return RedirectResponse
     * @throws Throwable
     */
    public function renew(ManualSubscriptionRenewRequest $request, User $user): RedirectResponse
    {
        $entrant = null;
        if (Membership::APPLIES_TO_ENTRANT == $request->membership_type) {
            $entrant = $user->entrants->first();
        }

        DB::beginTransaction();
        // Validate the request...
        $optIns = ['retain_data', 'email'];
        $optInRequest = [];


        $optInRequest = $user->getOptinValues(
            ['retain_data', 'email'],
            [
                'can_retain_data' => $request->post('can_retain_data'),
                'can_email' => $request->post('can_email'),
            ]
        );
//        /* @todo this should be a method on the model or something */
//        foreach ($optIns as $optin) {
//            if ($request->post('can_' . $optin) == '1') {
//                $optInRequest['can_' . $optin] = 1;
//                $optInRequest[$optin . '_opt_in'] = Carbon::now();
//            } else {
//                $optInRequest['can_' . $optin] = 0;
//                $optInRequest[$optin . '_opt_out'] = Carbon::now();
//            }
//        }

        if (!$user->update(
            array_merge(
                ['email' => $request->post('email'),],
                $optInRequest
            )
        )) {
            DB::rollBack();
            return redirect()->back()->withErrors(['msg' => 'Could not save user']);
        }

        $payment = new Payment();
        $payment->user()->associate($user);
        $payment->amount = MembershipPurchaseController::getAmount($request->membership_type);
        $payment->source = $request->post('payment_method');

        if ($entrant instanceof Entrant) {
            $payment->entrant()->associate($entrant);
        }
        if (!$payment->save()) {
            DB::rollBack();
            return redirect()->back()->withErrors(['msg' => 'Could not save payment']);
        }

        $membershipPurchase = new MembershipPurchase();
        $membershipPurchase->type = $request->membership_type;
        $membershipPurchase->amount = MembershipPurchaseController::getAmount($request->type);
        if ($entrant instanceof Entrant) {
            $membershipPurchase->entrant()->associate($entrant);
        }
        $membershipPurchase->user()->associate($user);
        $membershipPurchase->end_date = Membership::getRenewalDate();
        $membershipPurchase->start_date = Carbon::now();

        // Todo record payment here
        if ($membershipPurchase->save()) {
            DB::commit();
            return redirect()->route('members.list');
        }
        DB::rollBack();

        return redirect()->back()->withErrors(['msg' => 'Could not save membership purchase']);
    }
}
