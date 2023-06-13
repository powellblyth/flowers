<?php

namespace App\Nova\Filters;

use App\Models\Membership;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class FilterMembershipByType extends Filter
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
    public function apply(Request $request, $query, $value): Builder
    {
        if ($value) {
            $query = $query
                ->where('type', $value);
        }
        return $query;
    }

    /**
     * Get the filter's available options.
     *
     * @param Request $request
     * @return array
     */
    public function options(Request $request): array
    {
        return array_flip(Membership::getTypes());
    }
}
