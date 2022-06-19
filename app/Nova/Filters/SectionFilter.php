<?php

namespace App\Nova\Filters;

use App\Models\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Laravel\Nova\Filters\Filter;

class SectionFilter extends Filter
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
     * @param Request $request
     * @param Builder $query
     * @param mixed $value
     * @return Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query->where('section_id', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param Request $request
     * @return array
     */
    public function options(Request $request)
    {
        return Cache::remember(
            'all_sections',
            '1000',
            fn() => Section::orderBy('number')->get()->pluck('id', 'name')->toArray()
        );
    }
}
