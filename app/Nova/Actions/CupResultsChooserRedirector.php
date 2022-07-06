<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class CupResultsChooserRedirector extends Action
{
    use InteractsWithQueue, Queueable;

    public $showOnTableRow = true;
    public $showOnIndex = false;
    public $confirmButtonText = 'Choose Winner';
    public $name = 'Choose Winner';
    /**
     * The text to be used for the action's cancel button.
     *
     * @var string
     */
    public $cancelButtonText = 'Cancel';

    /**
     * Determine where the action redirection should be without confirmation.
     *
     * @var bool
     */
    public $withoutConfirmation = true;

    /**
     * The text to be used for the action's confirmation text.
     *
     * @var string
     */
    public $confirmText = 'Choose a winner for this cup';

    /**
     * Perform the action on the given models.
     *
     * @param ActionFields $fields
     * @param Collection $sections
     * @return array|string[]
     */
    public function handle(ActionFields $fields, Collection $cups)
    {
        $params = [];
        // Can only do one at once.
        foreach ($cups as $model) {
            $params['cup'] = $model;
            // can only do one cup at once
        }
        return Action::openInNewTab(route('cups.show', $params));
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
