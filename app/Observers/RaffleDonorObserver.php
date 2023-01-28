<?php

namespace App\Observers;

use App\Models\RaffleDonor;

class RaffleDonorObserver
{
    /**
     * Handle the RaffleDonor "created" event.
     *
     * @param RaffleDonor $raffleDonor
     * @return void
     */
    public function creating(RaffleDonor $raffleDonor)
    {
        $this->enforceWebsite($raffleDonor);
    }

    /**
     * Handle the RaffleDonor "updated" event.
     *
     * @param RaffleDonor $raffleDonor
     * @return void
     */
    public function updating(RaffleDonor $raffleDonor)
    {
        $this->enforceWebsite($raffleDonor);
    }

    /**
     * Handle the RaffleDonor "deleted" event.
     *
     * @param RaffleDonor $raffleDonor
     * @return void
     */
    public function deleted(RaffleDonor $raffleDonor)
    {
        //
    }

    /**
     * Handle the RaffleDonor "restored" event.
     *
     * @param RaffleDonor $raffleDonor
     * @return void
     */
    public function restored(RaffleDonor $raffleDonor)
    {
        //
    }

    /**
     * Handle the RaffleDonor "force deleted" event.
     *
     * @param RaffleDonor $raffleDonor
     * @return void
     */
    public function forceDeleted(RaffleDonor $raffleDonor)
    {
        //
    }

    private function enforceWebsite(RaffleDonor $raffleDonor): void
    {
        if (is_null($raffleDonor->website)) {
            return;
        }
        if (empty($raffleDonor->website)) {
            return;
        }
        // @TODO regex this
        if (str_starts_with($raffleDonor->website, 'http://')) {
            return;
        }
        if (str_starts_with($raffleDonor->website, 'https://')) {
            return;
        }

        $raffleDonor->website = 'https://' . $raffleDonor->website;
    }
}
