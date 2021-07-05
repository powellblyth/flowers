<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;

class Entrant extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Entrant::class;
    public static $group = 'members';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'full_name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'firstname', 'familyname','membernumber'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Text::make('First Name', 'firstname')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Family Name', 'familyname')
                ->sortable()
                ->rules('required', 'max:255'),

            BelongsTo::make('Family Manager', 'user', \App\Nova\User::class)
                ->sortable(),

            HasMany::make('Entries'),

            Number::make('Age')->default('Adult'),

            Boolean::make('Can Retain Data')
                ->hideFromIndex(),

            DateTime::make('Retain Data Opt in')
                ->onlyOnDetail()->readonly(),

            DateTime::make('Retain Data Opt out')
                ->onlyOnDetail()->readonly(),

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
        return [];
    }
}