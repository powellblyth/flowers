<?php

namespace App\Observers;

use App\Jobs\SyncUserToMailChimpJob;
use App\Jobs\UnsubscribeEmailAddressJob;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserObserver
{

    public function created(User $user)
    {
        $user->createDefaultEntrant();
    }

    // if the user email changed, remove the old address
    // if the user is removed remove them
    public function updated(User $user)
    {
        // If the email has changed, then attempt to unsubscribe the old address
        if ($user->isDirty('email') && !empty($user->getOriginal('email'))) {
            Log::debug('unsubscribing ' . $user->getOriginal('email'));
            UnsubscribeEmailAddressJob::dispatch($user->getOriginal('email'));
        }

        // If the user status changed, and the user has not been made inactive, unsubscribe (???)
        if ($user->isDirty('status') && $user->status === User::STATUS_INACTIVE) {
            // Users might NEVER have had an email address
            // Yes this is dupe. Will fix along with unittest one day
            if (!empty($user->getOriginal('email'))) {
                Log::debug('unsubscribing ' . $user->getOriginal('email'));
                UnsubscribeEmailAddressJob::dispatch($user->getOriginal('email'));
            }
        }
    }

    public function saved(User $user)
    {
        // If the user could not email, and the can_email flag is not dirty, no point in
        // reunsubscribing people
        if (!$user->can_email && !$user->isDirty(['can_email', 'can_retain_data'])){
            return;
        }

        // If the user CAN email, or the can_email or can_retain_data flags are dirty
        if ($user->isDirty(['can_email', 'can_retain_data', 'email', 'is_committee'])) {
            Log::debug('user is dirty');
            Log::debug(print_r($user->getDirty(), true));
            SyncUserToMailChimpJob::dispatch($user);
        }
    }
}
