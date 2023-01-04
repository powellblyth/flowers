<?php

namespace App\Nova\Metrics;

use App\Models\Membership;
use App\Models\MembershipPurchase;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class MembershipValueByMembershipType extends Partition
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
            with(['entrant', 'user', 'membership'])->active();

        // Might have to replace this with a custom query to format the numbers
        return $this->sum(
            $request,
            $salesQuery,
            'amount',
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
        return 0;now()->addMinutes(5);
    }
}
