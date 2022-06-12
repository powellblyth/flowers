<?php

namespace App\Observers;

use App\Models\PaymentCard;
use Illuminate\Support\Facades\Auth;

class PaymentCardObserver
{
    /**
     * Handle the PaymentCard "created" event.
     *
     * @param  \App\Models\PaymentCard  $paymentCard
     * @return void
     */
    public function created(PaymentCard $paymentCard)
    {
        //
    }

    /**
     * Handle the PaymentCard "updated" event.
     *
     * @param  \App\Models\PaymentCard  $paymentCard
     * @return void
     */
    public function updated(PaymentCard $paymentCard)
    {
        //
    }

    /**
     * Handle the PaymentCard "deleted" event.
     *
     * @param  \App\Models\PaymentCard  $paymentCard
     * @return void
     */
    public function deleted(PaymentCard $paymentCard)
    {
        $paymentCard->user->deletePaymentMethod($paymentCard->stripe_id);
    }

    /**
     * Handle the PaymentCard "restored" event.
     *
     * @param  \App\Models\PaymentCard  $paymentCard
     * @return void
     */
    public function restored(PaymentCard $paymentCard)
    {
        //
    }

    /**
     * Handle the PaymentCard "force deleted" event.
     *
     * @param  \App\Models\PaymentCard  $paymentCard
     * @return void
     */
    public function forceDeleted(PaymentCard $paymentCard)
    {
        //
    }
}
