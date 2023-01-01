<?php

namespace App\Nova;

use App\Nova\Actions\CreateEntry;
use App\Nova\Actions\RecordPayment;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;

class Entrant extends Resource
{
    /**
     * The model the resource corresponds to.
     */
    public static string $model = \App\Models\Entrant::class;
    public static $group = 'members';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'full_name';

    public function subtitle()
    {
        $subtitle = '';
        if ($this->user->first_name != $this->first_name) {
            $subtitle .= 'Family Manager: ' . $this->user->first_name . ' ' . $this->user->last_name . ' ';
        }
        if (empty($this->user->address_1)) {
            $subtitle .= $this->user->email . ', ';
        } else {
            $subtitle .= $this->user->address_1 . ', ';
        }
        return $subtitle . "{$this->user->postcode}";
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'first_name', 'family_name', 'membernumber'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Text::make('First Name', 'first_name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Family Name', 'family_name')
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
            DateTime::make('Created At', 'created_at')->onlyOnDetail()->readonly(),
            DateTime::make('Updated At', 'updated_at')->onlyOnDetail()->readonly(),

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
        return [];
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
            CreateEntry::make(),
            RecordPayment::make(),

        ];
    }
}
