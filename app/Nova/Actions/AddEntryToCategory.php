<?php

namespace App\Nova\Actions;

use App\Models\Category;
use App\Models\Entrant;
use App\Models\Entry;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class AddEntryToCategory extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param \Laravel\Nova\Fields\ActionFields $fields
     * @param \Illuminate\Support\Collection $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $models->each(function (Category $category) use ($fields) {
            $entry = new Entry();
            $entry->category()->associate($category);
            $entry->entrant_id = $fields['entrant_id'];
            $entry->show()->associate($category->show);
            $entry->save();
        });
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Text::make('nothing'),
            Select::make('entrant', 'entrant_id')
                ->searchable()
                ->rules('required', 'exists:entrants,id')
                ->options(Entrant::where('is_anonymised', false)->orderBy('family_name')->orderBy('first_name')
                    ->get()
                    ->mapWithKeys(fn(Entrant $entrant) => [$entrant->id=>$entrant->full_name])),
        ];
    }
}
