<?php

namespace App\Http\Livewire;

use App\Models\PaymentCard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CardDetails extends Component
{
    public bool $hidden = true;

    protected $listeners = [
        'paymentFailed' => 'handlePaymentFailed',
        'paymentSucceeded' => 'handlePaymentSucceeded',
    ];

    protected $errors = [];

    public function handlePaymentFailed($error)
    {
        dd($error);
        $errors[] = $error;
    }

    /**
     * @throws \Laravel\Cashier\Exceptions\CustomerAlreadyCreated
     */
    public function handlePaymentSucceeded($success)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->hasStripeId()) {
            $user->createAsStripeCustomer();
        }

        $isDefaultCard = false;
        $paymentMethod = $user->addPaymentMethod($success['payment_method']);
        // If there is no default payment method, we make this it
        if (!$user->hasDefaultPaymentMethod()) {
            $user->updateDefaultPaymentMethod($paymentMethod->asStripePaymentMethod());
            $isDefaultCard = true;
        }
        $paymentCard = new PaymentCard();
        $paymentCard->user()->associate($user);
        $paymentCard->is_default = $isDefaultCard;
        $paymentCard->setFromStripe($paymentMethod)->save();
        $this->redirect(route('paymentcards.index'));
    }

    public function render()
    {
        $intent = null;
        $error = null;
        try {
            $intent = Auth::user()->createSetupIntent();
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            Log::error($e);
            $error = $e->getMessage();
        } finally {
            return view('livewire.payment.card-details', [
                'intent' => $intent,
                'error' => $error,
                'stripeKey' => config('cashier.key'),
            ]);
        }
    }
}
