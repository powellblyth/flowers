<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Traits\Controllers\HasShowSwitcher;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use HasShowSwitcher;

    public function store(Request $request)
    {
        $this->getShowFromRequest($request);
        // Validate the request...

        $payment = new Payment();

        $payment->amount = $request->amount;
        $payment->source = $request->source;
        $payment->user()->associate($request->user);
        if ($request->entrant) {
            $payment->enrant()->associate($request->entrant);
        }
        $payment->year = (int) config('app.year');
        $payment->save();

        if ($request->entrant) {
            return redirect()->route('entrants.show', ['entrant' => $request->entrant]);
        } else {
            return redirect()->route('users.show', array('thing' => $request->user));
        }
    }
}
