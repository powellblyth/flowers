<?php

namespace App\Http\Livewire;

use App\Models\Membership;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Stripe\Exception\ApiConnectionException;

class ListSubscriptionsHeld extends Component
{
    public bool $hidden = true;

    public function render()
    {
        return view(
            'livewire.payment.list-subscriptions-held',
            [
                'subscriptions' => Auth::user()->subscriptions,
            ]
        );
    }
}
