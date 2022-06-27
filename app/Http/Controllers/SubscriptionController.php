<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Laravel\Cashier\SubscriptionBuilder;
use Stripe\Exception\InvalidRequestException;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response()
            ->view(
                'subscriptions.index',
                [
                    'subscriptions' => Auth::user()->subscriptions(),
                    'error' => $_GET['error'] ?? null,
                    'message' => $_GET['message'] ?? null,
                ]
            );
    }

    public function manageCards()
    {
        return response()
            ->view(
                'subscriptions.show-cards',
                [

                ]
            );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {

        return response()->view('subscriptions.updatePaymentMethod', [
        ]);
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response|\Illuminate\Http\RedirectResponse
     * @throws IncompletePayment
     * @TODO why does this not dependency inject?!
     */
    public function store(Request $request)
    {
        /** @var Membership $membership */
        $membership = Membership::find($request->membership_id);
        /** @var SubscriptionBuilder $subscriptionBuilder */
        $subscriptionBuilder = Auth::user()
            ->newSubscription(
                $membership->stripe_id,
                $membership->stripe_price,
            );

        $renewalDate = Membership::getRenewalDate();

        try {
            $checkout = $subscriptionBuilder
                ->skipTrial()
                ->price($membership->stripe_price)
                ->prorate()
                ->anchorBillingCycleOn($renewalDate)
                ->create();
            return response()
                ->redirectTo(
                    route('subscriptions.index')
                    . '?message='
                    . urlencode('Success - You are subscribed to ' . $membership->description)
                );
        } catch (InvalidRequestException $e) {
            Log::error($e->getMessage());
            return response()
                ->redirectTo(
                    route('subscriptions.index')
                    . '?error=' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Subscription $subscription
     * @return Response
     */
    public function show(Subscription $subscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Subscription $subscription
     * @return Response
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\Models\Subscription $subscription
     * @return Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Subscription $subscription
     * @return Response
     */
    public function destroy(Subscription $subscription)
    {
        //
    }
}
