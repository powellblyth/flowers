<?php

namespace App\Nova\Actions;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class AddCategoryAfter extends Action
{
    use InteractsWithQueue, Queueable;

    public $showOnTableRow = true;
    public $showOnIndex = false;
    /**
     * The text to be used for the action's confirm button.
     *
     * @var string
     */
    public $confirmButtonText = 'Insert Category Here';
    public $name = 'Insert Category Here';

    // How many rows of categories to show
    public static $numRows = 20;

    /**
     * The text to be used for the action's confirmation text.
     *
     * @var string
     */
    public $confirmText = 'Duplicate this category and add it to the list here??';

    /**
     * Perform the action on the given models.
     *
     * @param Collection[\App\Models\Category] $models
     * @return mixed
     * @throws \Exception
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        \DB::beginTransaction();

        try {
            // Disregard multiple selction
            /** @var Category $category */
            $category = $models->first();
            /** @var Category $newCategory */
            $newCategory = $category->replicate();

            // Now update all the sort orders to make space
            $category->show->categories()->where('sortorder', '>', $category->sortorder)
                ->each(function (Category $categoryToReOrder) {
                    $categoryToReOrder->incrementOrder(1)->save();
                });


            $newCategory->name = 'Copy of ' . $category->name;
            $newCategory->clonedFrom()->disassociate();
            $newCategory->created_at = Carbon::now();
            $newCategory->incrementOrder(1)->save();

        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
