<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

/**
 * @mixin \App\Models\RafflePrize
 */
class RafflePrize extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \App\Models\RafflePrize::class;

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
        'description',
        'notes',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            BelongsTo::make(__('Show'), 'show', Show::class)
                ->sortable()
            ->default(fn() => \App\Models\Show::OrderBy('start_date', 'DESC')->first()->id),
            BelongsTo::make(__('Donor'), 'raffleDonor', RaffleDonor::class)
                ->displayUsing(fn(RaffleDonor $donor)=>$donor->name)
                ->sortable()
            ->default(fn() => \App\Models\Show::OrderBy('start_date', 'DESC')->first()->id),
            BelongsTo::make(__('Contacted By'), 'contactedBy', CommitteeMember::class)
                ->dontReorderAssociatables()
                ->sortable()
                ->nullable(),
            BelongsTo::make(__('Winner'), 'winner', User::class)->sortable()->nullable(),
            Text::make(__('Prize Title'), 'name')->nullable(),
            Textarea::make(__('Prize Description '), 'description')->nullable(),
            Textarea::make(__('Notes'), 'notes')->nullable(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
