<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
    public function index(): Response
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

    public function manageCards(): Response
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
     * @throws IncompletePayment
     * @TODO why does this not dependency inject?!
     */
    public function store(Request $request): Response|RedirectResponse
    {
        /** @var Membership $membership */
        $membership = Membership::find($request->membership_id);
        $subscriptionBuilder = Auth::user()
            ->newSubscription(
                $membership->stripe_id,
                $membership->stripe_price,
            );

        $renewalDate = Membership::getRenewalDate();

        try {
            $subscriptionBuilder
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
                    . '?error=' . $e->getMessage()
                );
        }
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show(Subscription $subscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(Subscription $subscription)
    {
        //
    }
}
