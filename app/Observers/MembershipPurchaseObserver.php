<?php

namespace App\Observers;

use App\Jobs\SyncUserToMailChimpJob;
use App\Models\MembershipPurchase;

class MembershipPurchaseObserver
{
    public function creating(MembershipPurchase $membershipPurchase)
    {
        $membershipPurchase->created_by_id = \Auth::user()?->id;
    }

    public function saved(MembershipPurchase $membershipPurchase)
    {
        // This means the member's tag gets updated
        if ($membershipPurchase->user) {
            SyncUserToMailChimpJob::dispatch($membershipPurchase->user);
        }
    }
}
