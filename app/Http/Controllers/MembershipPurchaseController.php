<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MembershipPurchaseController extends Controller
{
    protected $templateDir = 'payments';
    protected $baseClass = 'App\MembershipPurchase';

    public function getAmount($type)
    {
        if ('single'  === $type)
        {
            $amount = 300;
        }
        else
        {
            $amount = 500;
        }
        return $amount;
    }
    
    public function store(Request $request)
    {
        // Validate the request...

        $thing = new $this->baseClass();

        $thing->type = $request->type;
        $thing->amount = $this->getAmount($request->type);
        $thing->entrant = $request->entrant ;
        $thing->save();
        return redirect()->route('entrants.show', array('thing' => $request->entrant));
    }

}
