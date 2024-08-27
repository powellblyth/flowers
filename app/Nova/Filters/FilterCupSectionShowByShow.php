<?php

namespace App\Nova\Filters;

use App\Models\Show;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Laravel\Nova\Filters\Filter;

class FilterCupSectionShowByShow extends Filter
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
            return $query->where('cup_section_show.show_id', $value);
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
            'all_shows_cup_section_show',
            '1000',
            fn() => Show::orderBy('start_date')->get()->pluck('id', 'name')->toArray(),
        );
    }
}
