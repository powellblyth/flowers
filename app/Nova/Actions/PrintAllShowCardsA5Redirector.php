<?php

namespace App\Nova\Actions;

use App\Models\Show;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;

class PrintAllShowCardsA5Redirector extends Action
{
    use InteractsWithQueue, Queueable;

    public $showOnTableRow = true;
    public $showOnIndex = false;
    public $confirmButtonText = 'Print Card A5!';
    public $name = 'Print Cards A5';

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
    public $withoutConfirmation = false;

    /**
     * The text to be used for the action's confirmation text.
     *
     * @var string
     */
    public $confirmText = 'Open Print All Cards in A5?';

    /**
     * Perform the action on the given models.
     *
     * @return array|string[]|void
     */
    public function handle(ActionFields $fields, Collection $showsOrUsers)
    {
        // Can only do one at once.
        foreach ($showsOrUsers as $model) {
            return Action::openInNewTab(
                route(
                    'entries.printallA5',
                    ['show' => $model, 'since' => $fields->since]
                )
            );
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Select::make('Since')->options(
                Show::getHoursAgo()
            )->default(525600)
        ];
    }
}
