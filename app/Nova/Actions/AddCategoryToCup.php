<?php

namespace App\Nova\Actions;

use App\Models\Category;
use App\Models\Cup;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;

class AddCategoryToCup extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * The text to be used for the action's confirm button.
     *
     * @var string
     */
    public $confirmButtonText = 'Add Category(ies)';

    /**
     * Perform the action on the given models.
     *
     * @param Collection<Category> $categories
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $categories)
    {
        /** @var Cup $cup */
        $cup = Cup::findOrFail($fields['cup_id']);
        $categories->each(function (Category $category) use ($cup) {
            if ($cup->categories()->find($category->id)) {
                return;
            }
            $cup->categories()->save($category);
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
            Select::make(__('Cup'), 'cup_id')
                ->required()
                ->options(
                    Cup::orderBy('sort_order')
                        ->get()
                        ->mapWithKeys(fn(Cup $cup) => [$cup->id => $cup->name])
                ),
        ];
    }
}
