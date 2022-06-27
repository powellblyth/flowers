<?php

namespace App\Nova;

use App\Nova\Actions\DuplicateMembership;
use App\Nova\Filters\FilterByYear;
use App\Nova\Metrics\MembershipPriceByMembershipType;
use App\Nova\Metrics\MembershipsByMembershipType;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class Membership extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Membership::class;
    public static $group = 'Configuration';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'label';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'label',
        'description',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Text::make('Label')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Sku')
                ->sortable()
                ->rules('required', 'max:255'),

            Select::make('Applies To')
                ->sortable()
                ->options([
                    \App\Models\Membership::getTypes(),
                ]),

            Currency::make('Price', 'price_gbp')->required()
                ->hideFromIndex()
                ->sortable()->currency('GBP')->asMinorUnits(),

            Text::make('Stripe ID', 'stripe_id')->required()
                ->hideFromIndex(),

            Text::make('Stripe Price', 'stripe_price')->required()
                ->hideFromIndex(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(Request $request)
    {
        return [
            MembershipPriceByMembershipType::make(),
            MembershipsByMembershipType::make(),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            FilterByYear::make(),
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
            DuplicateMembership::make(),
        ];
    }
}
