<?php

namespace App\Nova;

use App\Nova\Actions\AddCategoryToCup;
use App\Nova\Actions\ChangeSectionAction;
use App\Nova\Actions\CreateUsersEntry;
use App\Nova\Filters\FilterByShow;
use App\Nova\Filters\SectionFilter;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use OptimistDigital\NovaInlineTextField\InlineText;

class Category extends Resource
{
    /**
     * The model the resource corresponds to.
     */
    public static string $model = \App\Models\Category::class;
    public static $perPageOptions = [150, 50];
    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'numbered_name';

    public static $group = 'shows';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
        'number',
    ];

    /**
     * Default ordering for index query.
     */
    public static array $sort = [
        'show_id' => 'asc',
        'sortorder' => 'asc',
    ];

    public static $perPageViaRelationship = 100;
    public static int $perPage = 100;

    /**
     * Get the fields displayed by the resource.
     *
     * @param Request $request
     * @return array
     */
    public function fields(Request $request): array
    {
        return [

            Text::make('Name', 'numbered_name')
                ->sortable()
                ->onlyOnDetail(),
            InlineText::make('Number')
                ->rules('required', 'max:255')->required()
                ->onlyOnIndex(),
            InlineText::make('Name', 'name')
                ->onlyOnIndex(),

            InlineText::make('Sort Order', 'sortorder')
                ->onlyOnIndex()->sortable(),

            Text::make('Number')
                ->sortable()
                ->rules('required', 'max:255')->required()
                ->onlyOnForms(),

            Text::make('Name', 'name')
                ->rules('required', 'max:255')->required()
                ->onlyOnForms(),

            Number::make('Sort Order', 'sortorder')
                ->required()
                ->hideFromIndex(),

            InlineText::make(__('Minimum age'), 'minimum_age')->onlyOnIndex(),
            InlineText::make(__('Maximum age'), 'maximum_age')->onlyOnIndex(),

            Text::make('notes')->hideFromIndex(),

            Number::make(__('Minimum age'), 'minimum_age')->hideFromIndex()->nullable(),
            Number::make(__('Maximum age'), 'maximum_age')->hideFromIndex()->nullable(),

            Boolean::make(__('Private'), 'private')->hideFromIndex(),

            Currency::make('Price')->required()
                ->sortable()->currency('GBP')->asMinorUnits(),

            Currency::make('Late Price')->required()
                ->sortable()->currency('GBP')->asMinorUnits(),

            Currency::make('First Prize')->required()
                ->hideFromIndex()
                ->sortable()->currency('GBP')->asMinorUnits(),
            Currency::make('Second Prize')->required()
                ->hideFromIndex()
                ->sortable()->currency('GBP')->asMinorUnits(),
            Currency::make('Third Prize')->required()
                ->hideFromIndex()
                ->sortable()->currency('GBP')->asMinorUnits(),

            BelongsTo::make('Show')->sortable()->required(),
            BelongsTo::make('Section')->sortable()->required(),
            HasMany::make(__('Entries'), 'entries'),
            BelongsToMany::make(__('Judge Roles'), 'judgeRoles'),
            BelongsToMany::make(__('Cup'), 'cups'),

        ];
    }

    /**
     * Get the cards available for the request.
     */
    public function cards(Request $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     */
    public function filters(Request $request): array
    {
        return [
            FilterByShow::make(),
            SectionFilter::make(),
        ];
    }

    /**
     * Get the lenses available for the resource.
     */
    public function lenses(Request $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     */
    public function actions(Request $request): array
    {
        return [
            CreateUsersEntry::make()
                ->showOnTableRow(),
            AddCategoryToCup::make(),
            ChangeSectionAction::make(),
        ];
    }
}
