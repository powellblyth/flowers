<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\SubscriptionBuilder;

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
