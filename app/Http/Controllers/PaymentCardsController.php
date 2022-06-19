<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class PaymentCardsController extends Controller
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
                'paymentcards.index',
                [

                ]
            );
    }

    public function create()
    {

        return response()->view('subscriptions.updatePaymentMethod', [
        ]);
        //
    }
}
