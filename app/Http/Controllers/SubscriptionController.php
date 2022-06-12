<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\SubscriptionBuilder;

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
    public function create()
    {

        return response()->view('subscriptions.updatePaymentMethod', [
        ]);
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Membership $membership
     * @return Response
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

        $renewalDate = new Carbon('first day of June ' . date('Y'));
        if ($renewalDate->isBefore(new Carbon('Tomorrow'))) {
            $renewalDate = new Carbon('first day of June ' . (((int) date('Y')) + 1));
        }
        $checkout = $subscriptionBuilder
            ->skipTrial()
            ->price($membership->stripe_price)
            ->prorate()
            ->anchorBillingCycleOn($renewalDate)
            ->create();
        var_dump(json_decode($checkout->toJson()));
        var_dump($checkout->toJson());
        dump($membership->sku);
        //
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
