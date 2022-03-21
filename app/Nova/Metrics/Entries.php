<?php

namespace App\Nova\Metrics;

use App\Models\Membership;
use Laravel\Nova\Metrics\TrendResult;
use Laravel\Nova\Metrics\Value;

class Entries extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @return mixed
     */
    public function calculate()
    {
        /**
         * @var Membership $membership
         */
        $membership = Membership::orderBy('valid_to', 'DESC')->first();
        $membershipsSold = $membership->membershipsSold()->with('entrant')->with('user');
        return (new TrendResult())->trend([
            'Adult' => $membershipsSold->count(),
            'Junior' => 150,
            'July 3' => 200,
        ]);
        //        return $this->count($request, Model::class);
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
//            30 => __('30 Days'),
//            60 => __('60 Days'),
//            365 => __('365 Days'),
//            'TODAY' => __('Today'),
//            'MTD' => __('Month To Date'),
//            'QTD' => __('Quarter To Date'),
//            'YTD' => __('Year To Date'),
        ];
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
        return 'entries';
    }
}
