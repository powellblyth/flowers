<?php

namespace App\Nova\Filters;

use App\Models\Cup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Laravel\Nova\Filters\Filter;

class FilterByCup extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param Builder $query
     * @param mixed $value
     * @return Builder
     */
    public function apply(Request $request, $query, $value)
    {
        if ($value) {
            return $query->where('cup_id', $value);
        }
        return $query;
    }

    /**
     * Get the filter's available options.
     *
     * @return array
     */
    public function options(Request $request)
    {
        return Cache::remember(
            'all_cups',
            '1000',
            fn() => Cup::all()->pluck('id', 'name')->toArray(),
        );
    }
}
