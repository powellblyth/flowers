<?php

namespace App\Nova\Metrics;

use App\Models\Membership;
use App\Models\MembershipPurchase;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class MembershipsByMembershipType extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        /**
         * @var Membership $membership
         */
        $sales = MembershipPurchase::with(['entrant', 'user', 'membership']);
        return
            $this->count(
                $request,
                $sales,
                'membership_id'
            )->label(function ($value) {
                return Membership::find($value)->sku;
            });
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */

}
