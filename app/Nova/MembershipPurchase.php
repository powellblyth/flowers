<?php

namespace App\Nova;

use App\Nova\Filters\FilterByActive;
use App\Nova\Filters\FilterByYear;
use App\Nova\Filters\FilterMembershipByType;
use App\Nova\Metrics\MembershipValueByMembershipType;
use App\Nova\Metrics\ActiveMembershipsByMembershipType;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Select;

/** @mixin \App\Models\MembershipPurchase */
class MembershipPurchase extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \App\Models\MembershipPurchase::class;
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
                ])->displayUsingLabels(),

            Currency::make('Amount')->required()
                ->hideFromIndex()
                ->sortable()->currency('GBP')->asMinorUnits(),

            DateTime::make(__('Expires'), 'end_date')->readonly()->format('Y-MM-DD'),
            DateTime::make(__('Created At'), 'created_at')->readonly(),
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
            MembershipValueByMembershipType::make(),
            ActiveMembershipsByMembershipType::make(),
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
            FilterByActive::make(),
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
