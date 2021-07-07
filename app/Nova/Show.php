<?php

namespace App\Nova;

use App\Nova\Actions\DuplicateShowAction;
use App\Nova\Actions\PrintAllCardsRedirector;
use App\Nova\Actions\PrintLookupSheetsRedirector;
use App\Nova\Actions\PrintTableTopCardsRedirector;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Show extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Show::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    public static $group = 'shows';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name',
    ];
    /**
     * Default ordering for index query.
     *
     * @var array
     */
    public static $sort = [
        'start_date' => 'desc'
    ];

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
            ID::make()->sortable(),

            Text::make('Name', 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            DateTime::make('Start Date')
                ->sortable()->format('Y-MM-DD HH:m'),

            DateTime::make('End Date', 'ends_date')
                ->sortable()->format('Y-MM-DD HH:m'),

            DateTime::make('Entries Closed Deadline', 'entries_closed_deadline')
                ->sortable()->format('Y-MM-DD HH:m'),

            DateTime::make('Late Entry Deadline')
                ->sortable()->format('Y-MM-DD HH:m'),

            Select::make('Status')
                ->sortable()
                ->options(['planned' => 'Planned', 'current' => 'Current', 'passed' => 'Passed'])
                ->displayUsingLabels()
            ,
            \App\Nova\Fields\Badge::make('Status', 'status', function () {
                return $this->status;
            })->label(function ($value) {
                return __($value);
            })->map([
                'planned' => 'danger',
                'current' => 'warning',
                'passed' => 'success',
            ])->sortable(),
            HasMany::make('Categories'),

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
        return [];
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
        return [
            DuplicateShowAction::make()->showOnIndex(),
            PrintAllCardsRedirector::make()->showOnIndex(),
            PrintTableTopCardsRedirector::make()->showOnIndex(),
            PrintLookupSheetsRedirector::make()->showOnIndex(),
        ];
    }
}
