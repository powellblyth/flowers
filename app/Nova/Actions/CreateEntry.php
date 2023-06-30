<?php

namespace App\Nova\Actions;

use App\Models\Category;
use App\Models\Entrant;
use App\Models\Entry;
use App\Models\Show;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;

class CreateEntry extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * The text to be used for the action's confirm button.
     *
     * @var string
     */
    public $confirmButtonText = 'Create Entry';
    public $name = 'Create Entry';

    // How many rows of categories to show
    public static $numRows = 20;

    /**
     * The text to be used for the action's confirmation text.
     *
     * @var string
     */
    public $confirmText = 'Are you sure you want to create this Single membership?';

    /**
     * Perform the action on the given models.
     *
     * @param Collection[\App\Models\User] $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $models->each(function (Entrant $entrant) use ($fields) {
            for ($x = 1; $x <= self::$numRows; $x++) {
                if ($fields['category_id_' . $x]) {
                    $entry = new Entry();
                    $entry->entrant_id = $entrant->id;
                    $entry->category_id = $fields['category_id_' . $x];
                    $entry->show()->associate(Show::public()->newestFirst()->first()); //hard code hell
                    $entry->save();
                }
            }
        });
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        $categories = Category::forShow(Show::public()->newestFirst()->first())->inOrder()->get();
        $categoriesArray = [];
        foreach ($categories as $category) {
            $categoriesArray[$category->id] = $category->numbered_name;
        }
        $selects = [];
        for ($x = 1; $x <= self::$numRows; $x++) {
            $selects[] = Select::make('category_id_' . $x)->options($categoriesArray);
        }
        return $selects;
    }
}
