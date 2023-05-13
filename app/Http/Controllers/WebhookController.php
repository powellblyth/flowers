<?php

namespace App\Http\Controllers;

use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Symfony\Component\HttpFoundation\Response;

class WebhookController extends CashierController
{
    /**
     * Handle invoice payment succeeded.
     *
     * @return Response
     */
    public function handleInvoicePaymentSucceeded()
    {
        // Handle The Event
    }
    //
}
