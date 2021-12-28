<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use NZTim\Mailchimp\Mailchimp;
use NZTim\Mailchimp\Member;

class UserObserver
{

    public function created(User $user)
    {
        $user->makeDefaultEntrant();
    }

    // if the user email changed, remove the old address
    // if the user is removed remove them
    public function updated(User $user)
    {
        $listID = config('flowers.mailchimp.mailing_list_id');
        if ($user->isDirty('email') && !empty($user->getOriginal('email'))) {
            $mailchimp = new Mailchimp(config('flowers.mailchimp.mailing_list_key'));
            Log::debug('unsubscribing ' . $user->getOriginal('email'));
            $mailchimp->unsubscribe($listID, $user->getOriginal('email'));
        }
        if ($user->isDirty('status') && $user->status !== User::STATUS_INACTIVE) {
            $mailchimp = new Mailchimp(config('flowers.mailchimp.mailing_list_key'));
            Log::debug('unsubscribing ' . $user->getOriginal('email'));
            $mailchimp->unsubscribe($listID, $user->getOriginal('email'));
        }
    }

    public function saved(User $user)
    {
        Log::debug('user  ' . $user->id . ' saving');

        if ($user->isDirty('can_email') || $user->isDirty('can_retain_data') || $user->isDirty('email')) {
            $listID = config('flowers.mailchimp.mailing_list_id');
            $mailchimp = new Mailchimp(config('flowers.mailchimp.mailing_list_key'));

            $email = $user->safe_email;
            Log::debug($user->full_name . ' ' . $email . ' (' . $user->email . ') has changed');
            if ($user->can_retain_data && $user->can_email) {
                $member = (new Member($email))->language('en');
                $member = $member->confirm(false)->status('subscribed');
                $mailchimp->addUpdateMember($listID, $member);
                Log::debug("subscribing");
            } elseif ($mailchimp->check($listID, $email)) {
                // If the user is unsubscribed, we cannot add them as unsubscribed
                // so we only change them if they already exist
                $mailchimp->unsubscribe($listID, $email);
                Log::debug("unsubscribing");
            }
        }
    }
}
