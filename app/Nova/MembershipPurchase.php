<?php

namespace App\Nova;

use App\Nova\Actions\DuplicateMembership;
use App\Nova\Filters\FilterByShow;
use App\Nova\Filters\FilterByYear;
use App\Nova\Filters\FilterMembershipByType;
use App\Nova\Metrics\MembershipPriceByMembershipType;
use App\Nova\Metrics\MembershipsByMembershipType;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

/** @mixin \App\Models\MembershipPurchase */
class MembershipPurchase extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\MembershipPurchase::class;
    public static $group = 'Memberships';

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
        'number',
        'amount',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            BelongsTo::make('User'),
            BelongsTo::make('Entrant'),
            Select::make('Type')
                ->sortable()
                ->options([
                    \App\Models\Membership::APPLIES_TO_ENTRANT => 'Entrant',
                    \App\Models\Membership::APPLIES_TO_USER => 'Family',
                ]),

            Number::make('Year')->readonly()->displayUsing(function ($value) {
                if ( $this->start_date) {
                    return $this->start_date->format('Y');
                }
            })->exceptOnForms(),
            Currency::make('Amount')->required()
                ->hideFromIndex()
                ->sortable()->currency('GBP')->asMinorUnits(),

            DateTime::make('Start Date')->format('DD MMM Y'),
            DateTime::make('End Date')->format('DD MMM Y'),
            //            Badge::make('End Date')->label(function ($value): string {
            //                return 'error';
            ////                dump($value);
            //            })->value(function ($value){
            //                return 'moo';
            //            })
            //            ->map(['moo'=>'success'])

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
            FilterMembershipByType::make(),
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

        ];
    }
}
