<?php

namespace App\Observers;

use App\Models\PaymentCard;
use Illuminate\Support\Facades\Auth;
use Stripe\Exception\InvalidRequestException;

class PaymentCardObserver
{
    /**
     * Handle the PaymentCard "created" event.
     *
     * @param PaymentCard $paymentCard
     * @return void
     */
    public function created(PaymentCard $paymentCard)
    {
        //
    }

    /**
     * Handle the PaymentCard "updated" event.
     *
     * @param PaymentCard $paymentCard
     * @return void
     */
    public function updated(PaymentCard $paymentCard): void
    {
        //
    }

    /**
     * Handle the PaymentCard "deleted" event.
     *
     * @param PaymentCard $paymentCard
     * @return void
     */
    public function deleted(PaymentCard $paymentCard): void
    {
        try {
            $paymentCard->user->deletePaymentMethod($paymentCard->stripe_id);
        } catch (InvalidRequestException) {
            // Probably becaues the card is already deleted
            ; // We ignore
        }
    }

    /**
     * Handle the PaymentCard "restored" event.
     *
     * @param PaymentCard $paymentCard
     * @return void
     */
    public function restored(PaymentCard $paymentCard)
    {
        //
    }

    /**
     * Handle the PaymentCard "force deleted" event.
     *
     * @param PaymentCard $paymentCard
     * @return void
     */
    public function forceDeleted(PaymentCard $paymentCard)
    {
        //
    }
}
