<?php

namespace App\Observers;

use App\Models\PaymentCard;
use Stripe\Exception\InvalidRequestException;

class PaymentCardObserver
{
    /**
     * Handle the PaymentCard "created" event.
     *
     * @return void
     */
    public function created(PaymentCard $paymentCard)
    {
        //
    }

    /**
     * Handle the PaymentCard "updated" event.
     */
    public function updated(PaymentCard $paymentCard): void
    {
        //
    }

    /**
     * Handle the PaymentCard "deleted" event.
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
     * @return void
     */
    public function restored(PaymentCard $paymentCard)
    {
        //
    }

    /**
     * Handle the PaymentCard "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(PaymentCard $paymentCard)
    {
        //
    }
}
