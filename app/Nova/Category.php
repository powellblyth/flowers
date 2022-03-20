<?php

namespace App\Nova;

use App\Nova\Filters\FilterByShow;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use OptimistDigital\NovaInlineTextField\InlineText;

class Category extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Category::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'numbered_name';

    public static $group = 'shows';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'number',
    ];
    /**
     * Default ordering for index query.
     *
     * @var array
     */
    public static $sort = [
        'section_id' => 'asc',
        'sortorder' => 'asc',
    ];

    public static $perPageViaRelationship = 100;

    /**
     * Build an "index" query for the given resource.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        if (empty($request->get('orderBy'))) {
            $query->getQuery()->orders = [];

            return $query->orderBy(key(static::$sort), reset(static::$sort));
        }

        return $query;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [

            Text::make('Name', 'numbered_name')
                ->sortable()
            ->onlyOnDetail(),
            InlineText::make('Number')
                ->rules('required', 'max:255')->required()
                ->onlyOnIndex(),
            InlineText::make('Name', 'name')
                ->onlyOnIndex(),

            InlineText::make('Sort Order', 'sortorder')
                ->onlyOnIndex()->sortable(),

            Text::make('Number')
                ->sortable()
                ->rules('required', 'max:255')->required()
                ->onlyOnForms(),

            Text::make('Name', 'name')
                ->rules('required', 'max:255')->required()
            ->onlyOnForms(),

            Number::make('Sort Order', 'sortorder')
                ->required()
                ->hideFromIndex(),

            InlineText::make(__('Minimum age'), 'minimum_age')->onlyOnIndex(),
            InlineText::make(__('Maximum age'), 'maximum_age')->onlyOnIndex(),

            Number::make(__('Minimum age'), 'minimum_age')->hideFromIndex()->nullable(),
            Number::make(__('Maximum age'), 'maximum_age')->hideFromIndex()->nullable(),

            Currency::make('Price')->required()
                ->sortable()->currency('GBP')->asMinorUnits(),

            Currency::make('Late Price')->required()
                ->sortable()->currency('GBP')->asMinorUnits(),

            Currency::make('First Prize')->required()
                ->hideFromIndex()
                ->sortable()->currency('GBP')->asMinorUnits(),
            Currency::make('Second Prize')->required()
                ->hideFromIndex()
                ->sortable()->currency('GBP')->asMinorUnits(),
            Currency::make('Third Prize')->required()
                ->hideFromIndex()
                ->sortable()->currency('GBP')->asMinorUnits(),

            BelongsTo::make('Show')->sortable()->required(),
            BelongsTo::make('Section')->sortable()->required(),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(Request $request)
    {
        return [FilterByShow::make()];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
