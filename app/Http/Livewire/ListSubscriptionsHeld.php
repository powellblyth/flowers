<?php

namespace App\Http\Livewire;

use App\Models\Membership;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ListSubscriptionsHeld extends Component
{
    public bool $hidden = true;

    public function render()
    {
        /** @var User $user */
        $user = Auth::user();

        $error = null;
        $paymentCards = Auth::user()->paymentCards;

        return view(
            'livewire.payment.list-subscriptions-held',
            [
                'subscriptions' => $user->subscriptions,
                'manualMemberships' => $user->membershipPurchases()->active()->get(),
                'membershipOptions' => Membership::whereNotNull('stripe_id')->get(),
                'payment_cards' => $paymentCards,
                'error' => $error,
            ]
        );
    }
}
