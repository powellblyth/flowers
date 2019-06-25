<?php

namespace App\Http\Controllers;

use App\MembershipPurchase;
use Illuminate\Http\Request;

class MembershipPurchaseController extends Controller {
    protected $templateDir = 'payments';
    protected $baseClass = 'App\MembershipPurchase';

    public function getAmount($type) {
        if ('single' === $type) {
            $amount = 300;
        } else {
            $amount = 500;
        }
        return $amount;
    }

    public function store(Request $request) {
        // Validate the request...

        $thing = new MembershipPurchase();
//var_dump([$request->type]);die();
        $thing->type = $request->type;
        $thing->amount = $this->getAmount($request->type);
        if ('single' == $request->type) {
            $thing->entrant_id = $request->entrant;
        }
        $thing->user_id = $request->user;
        $thing->year = (int)config('app.year');
        $thing->save();

        if ('single' == $request->type) {
            return redirect()->route('entrants.show', array('thing' => $request->entrant));
        } else {
            return redirect()->route('user.show', array('thing' => $request->user));
        }
    }

}
