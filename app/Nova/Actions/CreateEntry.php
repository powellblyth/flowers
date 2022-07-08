<?php

namespace App\Nova\Actions;

use App\Models\Category;
use App\Models\Entrant;
use App\Models\Membership;
use App\Models\MembershipPurchase;
use App\Models\User;
use Carbon\Carbon;
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

    /**
     * The text to be used for the action's confirmation text.
     *
     * @var string
     */
    public $confirmText = 'Are you sure you want to create this Single membership?';

    /**
     * Perform the action on the given models.
     *
     * @param ActionFields $fields
     * @param Collection[\App\Models\User] $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $models->each(function (Entrant $entrant) use ($fields) {
            for ($x=1; $x<=10;$x++){
                if ($fields['category_id_'.$x]) {
                    $entry = new \App\Models\Entry();
                    $entry->entrant_id = $entrant->id;
                    $entry->category_id = $fields['category_id_' . $x];
                    $entry->show_id = 6; //hard code hell
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
        $categories = Category::where('show_id',6)->orderBy('sortorder')->pluck('number', 'id')->toArray();
        return [
            Select::make('category_id_1')->options($categories),
            Select::make('category_id_2')->options($categories),
            Select::make('category_id_3')->options($categories),
            Select::make('category_id_4')->options($categories),
            Select::make('category_id_5')->options($categories),
            Select::make('category_id_6')->options($categories),
            Select::make('category_id_7')->options($categories),
            Select::make('category_id_8')->options($categories),
            Select::make('category_id_9')->options($categories),
            Select::make('category_id_10')->options($categories),
        ];
    }
}
