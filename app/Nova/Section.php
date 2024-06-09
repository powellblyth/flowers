<?php

namespace App\Nova;

use App\Nova\Actions\ResultsEntryRedirector;
use App\Nova\Filters\FilterByShow;
use App\Nova\Filters\FilterCupSectionShowByShow;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class Section extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \App\Models\Section::class;
    public static $perPageViaRelationship = 20;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'display_name_show';
    public static $group = 'Configuration';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'number', 'notes',
    ];
    /**
     * Default ordering for index query.
     *
     * @var array
     */
    public static $sort = [
        'number' => 'asc'
    ];


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

            Text::make('Number')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Notes')
                ->showOnIndex(false),

            Boolean::make('Is Junior')
                ->showOnIndex(false),

            Text::make('Judges')
                ->showOnIndex(false),

            Text::make('Image')
                ->showOnIndex(false)->asHtml(),
            Text::make('Icon')
                ->onlyOnIndex()->asHtml()->displayUsing(function ($value) {
                    return str_replace(
                        [' height="', ' width="'],
                        [' style="height:45px" notheight="', '  notwidth="'],
                        $this->image
                    );
                }),

            BelongsTo::make(__('Show'), 'show', Show::class)->nullable(),
            BelongsTo::make(__('Judge Role'), 'judgeRole', JudgeRole::class)->nullable(),

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
        return [
            FilterByShow::make(),
            FilterCupSectionShowByShow::make(),
        ];
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
            ResultsEntryRedirector::make(),
        ];
    }
}
