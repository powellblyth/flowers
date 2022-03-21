<?php

namespace App\Nova\Metrics;

use App\Models\Entry;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class EntriesByEntrantType extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        /**
         * @var Entry $entries
         */
        $entries = Entry::query()->with('entrant');
//
//        $membershipsSold = $entries->membershipsSold()
//            ->with('entrant')
//            ->with('membership')
//            ->with('user')
//            ->getQuery();

//        return (new TrendResult())->trend([
//            'Adult' => $membershipsSold->count(),
//            'Junior' => 150,
//            'July 3' => 200,
//        ]);
//        $membership = Membership::orderBy('valid_to', 'DESC')->first();

        return $this->count(
            $request,
            $entries,
            'membership_id'
        );
    }

    /**
     * Determine for how many minutes the metric should be cached.
     */
    public function cacheFor(): \DateInterval|\DateTimeInterface|float|int
    {
         return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'entries-by-entrant-type';
    }
}
