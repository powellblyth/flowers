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

    public function updated(User $user)
    {
        if ($user->isDirty('email')) {
            $listID = env('MC_LIST');
            $mailchimp = new Mailchimp(env('MC_KEY'));
            Log::debug('unsubscribing ' . $user->getOriginal('email'));
            $mailchimp->unsubscribe($listID, $user->getOriginal('email'));
        }
        if ($user->isDirty('status') && $user->status !== User::STATUS_INACTIVE) {
            $listID = env('MC_LIST');
            $mailchimp = new Mailchimp(env('MC_KEY'));
            Log::debug('unsubscribing ' . $user->getOriginal('email'));
            $mailchimp->unsubscribe($listID, $user->getOriginal('email'));
        }

    }

    public function saved(User $user)
    {
//        die('hi');
        Log::debug('user  ' . $user->id . ' saving');


        if ($user->isDirty('can_email') || $user->isDirty('can_retain_data') || $user->isDirty('emaail')) {
            $listID = env('MC_LIST');
            $mailchimp = new Mailchimp(env('MC_KEY'));

            $email = $user->safe_email;
            $emailChanged = false;
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
