<?php

namespace App\Nova\Filters;

use App\Models\MembershipPurchase;
use App\Models\Show;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Filters\Filter;

class FilterByYear extends Filter
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
                ->where('start_date', '>=', $value . '-01-01')
                ->where('end_date', '<', ($value + 2) . '-01-01');
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
        $res = [];

        $startYear = 2020;
        $endYear = (int) date('Y');
        try {
            /**
             * @var MembershipPurchase $earliestMembershipYear
             */
            $earliestMembershipYear = MembershipPurchase::orderBy('start_date')->firstOrFail();
            $startYear = (int) $earliestMembershipYear->start_date->format('Y');
        } catch (ModelNotFoundException $e) {
            ;// don't care
        }
//dd([$startYear, $endYear]);

        for ($x = $startYear; $x <= $endYear; $x++) {
            $res[$x] = $x;
        }
        return $res;
    }
}
