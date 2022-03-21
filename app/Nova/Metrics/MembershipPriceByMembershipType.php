<?php

namespace App\Nova\Metrics;

use App\Models\Membership;
use App\Models\MembershipPurchase;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class MembershipPriceByMembershipType extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        Log::info($request);
        $salesQuery = MembershipPurchase::
            with(['entrant', 'user', 'membership']);

        // Might have to replace this with a custom query to format the numbers
        return $this->sum(
            $request,
            $salesQuery,
            'amount',
            'membership_id'
        )->label(function ($value) {
            return Membership::find($value)->sku;
        });
    }

    /**
     * Determine for how many minutes the metric should be cached.
     */
    public function cacheFor(): \DateInterval|\DateTimeInterface|float|int
    {
         return now()->addMinutes(5);
    }
}
