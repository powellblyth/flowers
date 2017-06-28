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
        $thing->entrant = $request->entrant ;
        $thing->save();
        return redirect()->route('entrants.show', array('thing' => $request->entrant));
    }
}
