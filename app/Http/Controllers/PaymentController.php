<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $templateDir = 'payments';

    public function store(Request $request)
    {
        // Validate the request...

        $payment = new Payment();

        $payment->amount     = $request->amount;
        $payment->source     = $request->source;
        $payment->entrant_id = $request->entrant;
        $payment->user_id    = $request->user;
        $payment->year       = (int) config('app.year');
        $payment->save();

        if ($request->entrant) {
            return redirect()->route('entrants.show', ['entrant' => $request->entrant]);
        } else {
            return redirect()->route('users.show', array('thing' => $request->user));
        }
    }
}
