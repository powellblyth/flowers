<?php

namespace App\Nova\Metrics;

use App\Models\MembershipPurchase;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class ActiveMembershipsByMembershipType extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $sales = MembershipPurchase::with(['entrant', 'user', 'membership'])->active();
        return
            $this->count(
                $request,
                $sales,
                'type'
            )->label(function ($value) {
                return match ($value) {
                    'entrant' => 'Single',
                    'user' => 'Family',
                    default => 'n/a',
                };
            });
    }

    /**
     * Determine for how many minutes the metric should be cached.
     */
    public function cacheFor(): \DateInterval|\DateTimeInterface|float|int
    {
        return 0;
        now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */

}
