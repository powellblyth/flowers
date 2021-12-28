<?php

namespace App\Nova\Lenses;

use App\Models\Show;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\LensRequest;
use Laravel\Nova\Lenses\Lens;

class CurrentShow extends Lens
{
    /**
     * Get the query builder / paginator for the lens.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return mixed
     */
    public static function query(LensRequest $request, $query)
    {
        return $request->withOrdering($request->withFilters(
            $query->whereHas('show', function (Builder $query) {
                $query->where('status', Show::STATUS_CURRENT);
            })
        ));
    }

    /**
     * Get the fields available to the lens.
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            BelongsTo::make('Show')->sortable()->required(),
        ];
    }

    /**
     * Get the cards available on the lens.
     *
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the lens.
     *
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available on the lens.
     *
     * @return array
     */
    public function actions(Request $request)
    {
        return parent::actions($request);
    }

    /**
     * Get the URI key for the lens.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'current-show';
    }
}
