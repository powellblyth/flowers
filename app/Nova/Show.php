<?php

namespace App\Nova;

use App\Nova\Actions\CheckShowRedirector;
use App\Nova\Actions\DuplicateShowAction;
use App\Nova\Actions\PrintAllCardsRedirector;
use App\Nova\Actions\PrintLookupSheetsRedirector;
use App\Nova\Actions\PrintTableTopCardsRedirector;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class Show extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \App\Models\Show::class;

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
    public static array $sort = [
        'start_date' => 'desc'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Name', 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            DateTime::make('Start Date')
                ->sortable()->format('MMM D HH:mm'),

            DateTime::make('End Date', 'ends_date')
                ->sortable()->format('MMM D HH:mm'),

            DateTime::make('Entries Closed Deadline', 'entries_closed_deadline')
                ->sortable()->format('MMM D HH:mm'),

            DateTime::make('Late Entry Deadline')
                ->sortable()->format('MMM D HH:mm'),

            Select::make('Status')
                ->sortable()
                ->options([\App\Models\Show::STATUS_PLANNED => 'Planned',
                           \App\Models\Show::STATUS_CURRENT => 'Current',
                           \App\Models\Show::STATUS_PASSED => 'Passed',
                ])
                ->displayUsingLabels()
            ,
            \App\Nova\Fields\Badge::make('Status', 'status', function () {
                return $this->status;
            })->label(function ($value) {
                return __($value);
            })->map([
                \App\Models\Show::STATUS_PLANNED => 'danger',
                \App\Models\Show::STATUS_CURRENT => 'warning',
                \App\Models\Show::STATUS_PASSED => 'success',
            ])->sortable(),
            HasMany::make('Categories'),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param Request $request
     * @return array
     */
    public function cards(Request $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param Request $request
     * @return array
     */
    public function filters(Request $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param Request $request
     * @return array
     */
    public function lenses(Request $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param Request $request
     * @return array
     */
    public function actions(Request $request): array
    {
        return [
            DuplicateShowAction::make()->showOnIndex(),
            PrintAllCardsRedirector::make()->showOnIndex(),
            PrintTableTopCardsRedirector::make()->showOnIndex(),
            PrintLookupSheetsRedirector::make()->showOnIndex(),
            CheckShowRedirector::make()->showOnIndex(),
        ];
    }
}
