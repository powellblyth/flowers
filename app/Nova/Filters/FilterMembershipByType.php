<?php

namespace App\Nova\Filters;

use App\Models\MembershipPurchase;
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
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
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
     * @return array
     */
    public function options(Request $request)
    {
        return [
            'Family' => MembershipPurchase::TYPE_FAMILY,
            'Individual' => MembershipPurchase::TYPE_INDIVIDUAL,
        ];
    }
}
