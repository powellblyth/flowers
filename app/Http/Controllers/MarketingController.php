<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class MarketingController extends Controller
{
    public function membership(Request $request): Factory|View|Application
    {
        return view('marketing.membership', [
            'family_cost' => Membership::getMembershipForType(Membership::APPLIES_TO_USER)->formatted_price,
            'individual_cost' => Membership::getMembershipForType(Membership::APPLIES_TO_ENTRANT)->formatted_price,
        ]);
    }
}
