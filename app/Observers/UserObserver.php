<?php

namespace App\Observers;

use App\Models\User;
use App\Services\MailChimpService;
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
        $mailchimp = app(MailChimpService::class);
//        $listID = config('flowers.mailchimp.mailing_list_id');
        // If the email has changed, then attemp to unsubscribe the old address
        if ($user->isDirty('email') && !empty($user->getOriginal('email'))) {
            Log::debug('unsubscribing ' . $user->getOriginal('email'));
            $mailchimp->unsubscribe($user->getOriginal('email'));
        }

        // If the user status changed, and the user has not been made inactive, unsubscribe (???)
        if ($user->isDirty('status') && $user->status === User::STATUS_INACTIVE) {
            Log::debug('unsubscribing ' . $user->getOriginal('email'));
            $mailchimp->unsubscribe($user->getOriginal('email'));
        }
    }

    public function saved(User $user)
    {
        /** @var MailChimpService $mailchimp */
        $mailchimp = app(MailChimpService::class);
        Log::debug('user  ' . $user->id . ' saving');

        // We saved the user, if these pertinant fields have changed then
        // Check if we can resubscribe or not
        if ($user->isDirty(['can_email', 'can_retain_data', 'email'])) {
            $email = $user->safe_email;
            Log::debug($user->full_name . ' ' . $email . ' (' . $user->email . ') has changed');
            if ($user->can_retain_data && $user->can_email) {
                $mailchimp->subscribe($email);
            } else {
                $mailchimp->unsubscribe($email);
            }
        }
    }
}
