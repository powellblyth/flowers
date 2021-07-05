<?php

namespace App\Nova\Actions;

use App\Jobs\CreateNewShowJob;
use App\Models\Show;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Text;

class PrintLookupSheetsRedirector extends Action
{
    use InteractsWithQueue, Queueable;

    public $showOnTableRow = true;
    public $showOnIndex = false;
    public $confirmButtonText = 'Print Lookup Sheets!';
    public $name = 'Print Lookup Sheets';
    /**
     * The text to be used for the action's cancel button.
     *
     * @var string
     */
    public $cancelButtonText = 'Cancel';

    /**
     * The text to be used for the action's confirmation text.
     *
     * @var string
     */
    public $confirmText = 'Print All Lookup Sheets';

    /**
     * Perform the action on the given models.
     *
     * @param \Illuminate\Support\Collection $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $shows)
    {
        $params = [];
        // Can only do one at once.
        foreach ($shows as $model) {
            $params['show'] = $model;
            // can only do one show at once
        }
        return Action::openInNewTab(route('category.lookupprint', $params));
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
        ];
    }
}