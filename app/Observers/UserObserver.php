<?php

namespace App\Observers;

use App\Jobs\syncUserToMailChimpJob;
use App\Jobs\unsubscribeEmailAddressJob;
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
//        $listID = config('flowers.mailchimp.mailing_list_id');
        // If the email has changed, then attempt to unsubscribe the old address
        if ($user->isDirty('email') && !empty($user->getOriginal('email'))) {
            Log::debug('unsubscribing ' . $user->getOriginal('email'));
            unsubscribeEmailAddressJob::dispatch($user->getOriginal('email'));
        }

        // If the user status changed, and the user has not been made inactive, unsubscribe (???)
        if ($user->isDirty('status') && $user->status === User::STATUS_INACTIVE) {
            // Users might NEVER have had an email address
            // Yes this is dupe. Will fix along with unittest one day
            if (!empty($user->getOriginal('email'))) {
                Log::debug('unsubscribing ' . $user->getOriginal('email'));
                unsubscribeEmailAddressJob::dispatch($user->getOriginal('email'));
            }
        }
    }

    public function saved(User $user)
    {
        if ($user->isDirty(['can_email', 'can_retain_data', 'email', 'is_committee'])) {
            syncUserToMailChimpJob::dispatch($user);
        }
    }
}
