<?php

namespace App\Listeners;

use App\Events\EntrantSaving;

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
     * @param EntrantSaving $event
     * @return void
     */
    public function handle(EntrantSaving $event): void
    {
        $entrant = $event->entrant;
        if ($entrant->isDirty('can_retain_data')) {
            if ($entrant->can_retain_data) {
                $entrant->retain_data_opt_in = date('Y-m-d H:i:s');
            } else {
                $entrant->retain_data_opt_out = date('Y-m-d H:i:s');
            }
        }
    }
}
