<?php

namespace App\Http\Controllers;

use App\Models\MembershipPurchase;
use Illuminate\Http\Request;

class MembershipPurchaseController extends Controller
{
    public function getAmount($type)
    {
        return 'single' === $type ? 300 : 500;
    }

    public function store(Request $request)
    {
        // Validate the request...

        $thing = new MembershipPurchase();
        $thing->type = $request->type;
        $thing->amount = $this->getAmount($request->type);
        if ('single' == $request->type) {
            $thing->entrant_id = $request->entrant;
        }
        $thing->number = $request->number;
        $thing->user_id = $request->user;
        $thing->year = (int) config('app.year');
        $thing->save();

        if ('single' == $request->type) {
            return redirect()->route('entrants.show', ['entrant' => $request->entrant]);
        } else {
            return redirect()->route('users.show', ['user' => $request->user]);
        }
    }
}
