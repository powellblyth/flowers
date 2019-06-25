<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $templateDir = 'payments';
    protected $baseClass = 'App\Payment';
    
    public function store(Request $request)
    {
        // Validate the request...

        $thing = new $this->baseClass();

        $thing->amount = $request->amount;
        $thing->source = $request->source;
        $thing->entrant_id = $request->entrant;
        $thing->user_id = $request->user;
        $thing->year = (int)config('app.year');
        $thing->save();
        if (  $request->entrant) {
            return redirect()->route('entrants.show', array('thing' => $request->entrant));
        }
        else{return redirect()->route('user.show', array('thing' => $request->user));}
    }
}
