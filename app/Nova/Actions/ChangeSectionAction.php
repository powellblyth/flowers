<?php

namespace App\Nova\Actions;

use App\Models\Category;
use App\Models\Section;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;

class ChangeSectionAction extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Change Section';

    /**
     * Perform the action on the given models.
     *
     * @param ActionFields $fields
     * @param Collection $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $newSection = Category::findOrFail($fields->get('section'));
        $models->each(function (Category $category) use ($newSection) {
            $category->section()->associate($newSection);
            $category->save();
        });
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Select::make('Section')
                ->options(
                    Section::all()->pluck('name', 'id')
                        ->toArray()
                ),
        ];
    }
}
