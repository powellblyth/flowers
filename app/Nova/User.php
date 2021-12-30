<?php

namespace App\Nova;

use App\Nova\Actions\PrintAllCardsRedirector;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\User::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'full_name';
    public static $group = 'members';


    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'email',
        'first_name',
        'last_name',
        'address_1',
        'address_2',
        'address_town',
        'postcode',
        'telephone',
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
            Gravatar::make()->maxWidth(50),
            Text::make('First Name', 'first_name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Family Name', 'last_name')
                ->sortable()
                ->rules('required', 'max:255'),

            Select::make('Status')
                ->sortable()
                ->rules('required', 'max:255')
                ->options(\App\Models\User::getAllStatuses()),

            Select::make('Type')
                ->sortable()
                ->options(\App\Models\User::getAllTypes()),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),
            Text::make('Address 1')->hideFromIndex(),
            Text::make('Address 2')->hideFromIndex(),
            Text::make('Town', 'address_town')->hideFromIndex(),
            Text::make('Postcode')->hideFromIndex(),
            Text::make('Telephone')->hideFromIndex(),
            Boolean::make('Can Retain Data')->hideFromIndex(),
            DateTime::make('Retain Data Opt in')->onlyOnDetail()->readonly(),
            DateTime::make('Retain Data Opt out')->onlyOnDetail()->readonly(),
            Boolean::make('Can Email')->hideFromIndex(),
            DateTime::make('Email Opt in')->onlyOnDetail()->readonly(),
            DateTime::make('Email Opt Out')->onlyOnDetail()->readonly(),
            Boolean::make('Can Phone')->hideFromIndex(),
            DateTime::make('Phone Opt in')->onlyOnDetail()->readonly(),
            DateTime::make('Phone Opt out')->onlyOnDetail()->readonly(),
            Boolean::make('Can SMS', 'can_sms')->hideFromIndex(),
            DateTime::make('SMS Opt out', 'sms_opt_in')->onlyOnDetail()->readonly(),
            DateTime::make('SMS Opt out', 'sms_opt_out')->onlyOnDetail()->readonly(),
            HasMany::make('Entrants'),
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
            PrintAllCardsRedirector::make()->showOnIndex(),
        ];
    }
}
