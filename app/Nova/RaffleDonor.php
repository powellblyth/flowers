<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasManyThrough;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

/**
 * @mixin \App\Models\RaffleDonor
 */
class RaffleDonor extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \App\Models\RaffleDonor::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
        'telephone',
        'website',
        'description',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make(__('Name'), 'name')->sortable()->required(),
            Text::make(__('Telephone Number'), 'telephone')->sortable(),
            Text::make(__('Web Address'), 'website')
                ->required(false)
                ->rules('sometimes:url:max:254')
                ->sortable(),
            Text::make(__('Email Address'), 'email')->sortable(),
            TextArea::make(__('Description'), 'description')
                ->sortable()
                ->required()
                ->rules('required:max:1000')
            ,
            Textarea::make(__('Notes'), 'notes')->sortable(),
            Boolean::make(__('Should Contact Again'), 'should_contact_again')->default(true)->sortable(),
            HasManyThrough::make(__('Raffle Donations'), 'rafflePrizes', RafflePrize::class),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
