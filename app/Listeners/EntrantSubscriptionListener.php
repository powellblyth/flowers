<?php

namespace App\Listeners;

use App\Events\EntrantSaving;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EntrantSubscriptionListener
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
     * @param  EntrantSaving  $event
     * @return void
     */
    public function handle(EntrantSaving $event)
    {
        $entrant = $event->entrant;
        if ($entrant->isDirty('can_retain_data')) {
            if ($entrant->can_retain_data) {
                $entrant->retain_data_opt_in = date('Y-m-d H:i:s');
            } else {
                $entrant->retain_data_opt_out = date('Y-m-d H:i:s');
            }
        }
        if ($entrant->isDirty('can_email')) {
            if ($entrant->can_email) {
                $entrant->email_opt_in = date('Y-m-d H:i:s');
            } else {
                $entrant->email_opt_out = date('Y-m-d H:i:s');
            }
        }
        if ($entrant->isDirty('can_sms')) {
            if ($entrant->can_sms) {
                $entrant->sms_opt_in = date('Y-m-d H:i:s');
            } else {
                $entrant->sms_opt_out = date('Y-m-d H:i:s');
            }
        }
        if ($entrant->isDirty('can_phone')) {
            if ($entrant->can_phone) {
                $entrant->phone_opt_in = date('Y-m-d H:i:s');
            } else {
                $entrant->phone_opt_out = date('Y-m-d H:i:s');
            }
        }
        if ($entrant->isDirty('can_post')) {
            if ($entrant->can_post) {
                $entrant->post_opt_in = date('Y-m-d H:i:s');
            } else {
                $entrant->post_opt_out = date('Y-m-d H:i:s');
            }
        }
    }
}
