<?php

namespace App\Listeners;

use App\Events\UserSaving;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserSubscriptionListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param UserSaving $event
     * @return void
     */
    public function handle(UserSaving $event)
    {
        $user = $event->user;
        if ($user->isDirty('can_retain_data')) {
            if ($user->can_retain_data) {
                $user->retain_data_opt_in = date('Y-m-d H:i:s');
            } else {
                $user->retain_data_opt_out = date('Y-m-d H:i:s');
            }
        }
        if ($user->isDirty('can_email')) {
            if ($user->can_email) {
                $user->email_opt_in = date('Y-m-d H:i:s');
            } else {
                $user->email_opt_out = date('Y-m-d H:i:s');
            }
        }
        if ($user->isDirty('can_sms')) {
            if ($user->can_sms) {
                $user->sms_opt_in = date('Y-m-d H:i:s');
            } else {
                $user->sms_opt_out = date('Y-m-d H:i:s');
            }
        }
        if ($user->isDirty('can_phone')) {
            if ($user->can_phone) {
                $user->phone_opt_in = date('Y-m-d H:i:s');
            } else {
                $user->phone_opt_out = date('Y-m-d H:i:s');
            }
        }
        if ($user->isDirty('can_post')) {
            if ($user->can_post) {
                $user->post_opt_in = date('Y-m-d H:i:s');
            } else {
                $user->post_opt_out = date('Y-m-d H:i:s');
            }
        }
    }
}
