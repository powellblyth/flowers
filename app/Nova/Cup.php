<?php

namespace App\Nova;

use App\Nova\Actions\CupResultsChooserRedirector;
use Benjacho\BelongsToManyField\BelongsToManyField;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Trix;

class Cup extends Resource
{

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \App\Models\Cup::class;

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
        'id', 'name', 'winning_criteria',
    ];
    /**
     * Default ordering for index query.
     *
     * @var array
     */
    public static $sort = [
        'cups.sort_order' => 'asc'
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

            Stack::make(
                __('Name'),
                [
                    Text::make(__('Name'), 'name')
                        ->sortable()
                        ->rules('required', 'max:255'),

                    Text::make(__('Winning Criteria'), 'winning_criteria')
                        ->sortable()
                        ->displayUsing(function ($value) {
                            return substr($value, 0, 62) . '...';
                        })
                        ->onlyOnIndex(),
                ],
            ),
            Text::make(__('Name'), 'name')
                ->rules('required', 'max:255')
                ->onlyOnForms(),
            Text::make(__('Winning Criteria'), 'winning_criteria')
                ->rules('required', 'max:255')
                ->hideFromIndex(),
            Trix::make(__('Rules'), 'rules')
                ->hideFromIndex(),
            Text::make(__('Prize Description'), 'prize_description')
                ->rules('max:255')
                ->hideFromIndex(),

            Select::make(__('Winning Basis'), 'winning_basis')
                ->required()
                ->displayUsingLabels()
                ->default(\App\Models\Cup::WINNING_BASIS_TOTAL_POINTS)
                ->options(\App\Models\Cup::getWinningBasisOptions()),

            Number::make(__('Sort Order'), 'sort_order')
                ->sortable(),

            Number::make(__('Number of results to display'), 'num_display_results')
                ->hideFromIndex(),
            Textarea::make(__('Judges\' notes'), 'judges_notes')
                ->hideFromIndex(),
            HasMany::make(__('Categories'), 'categories'),
            //            BelongsTo::make(__('Section (only if all categories are for this cup)'), 'section', Section::class)->nullable(),
            BelongsToMany::make(__('Judge Role'), 'judgeRoles')->nullable()
                ->canSee(
                    fn() => $this->resource->winning_basis === \App\Models\Cup::WINNING_BASIS_JUDGES_CHOICE
                ),

            BelongsToManyField::make('Sections', 'sections', Section::class),

            //            BelongsToMany::make(__('Sections'), 'sections')
            //                ->fields(function (Request $request, \App\Models\Section $section) {
            //                    return [
            //                        BelongsTo::make('section')
            //                            ->nullable()
            //                            ->searchable(),
            //                        //                        BelongsTo::make('cup'),
            //                    ];
            //                }),
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
            CupResultsChooserRedirector::make(),
        ];
    }
}
