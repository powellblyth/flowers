<?php

namespace App\Nova\Metrics;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class EntriesByLateness extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->count($request, Model::class, 'groupByColumn');
    }

    /**
     * Determine for how many minutes the metric should be cached.
     */
    public function cacheFor(): \DateInterval|\DateTimeInterface|float|int
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'entries-by-lateness';
    }
}
