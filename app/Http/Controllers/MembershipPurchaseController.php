<?php

namespace App\Http\Controllers;

use App\Models\Membership;


class MembershipPurchaseController extends Controller
{
    public static function getAmount($type): int
    {
        return Membership::APPLIES_TO_ENTRANT === $type ? 500 : 750;
    }
}
