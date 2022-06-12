<?php

namespace App\Http\Livewire;

use App\Models\Membership;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Stripe\Exception\ApiConnectionException;

class ListMemberships extends Component
{
    public bool $hidden = true;

    public function render()
    {
        $error = null;
        $paymentCards = Auth::user()->paymentCards;
        return view(
            'livewire.payment.list-memberships',
            [
                'membershipOptions' => Membership::whereNotNull('stripe_id')->get(),
                'payment_cards' => $paymentCards,
                'error' => $error,
            ]
        );
    }
}
