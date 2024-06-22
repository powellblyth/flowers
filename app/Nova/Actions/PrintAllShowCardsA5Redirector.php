<?php

namespace App\Nova\Actions;

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
                [
                    1 => '1 minute',
                    5 => '5 minutes',
                    10 => '10 minutes',
                    30 => '30 minutes',
                    60 => '1 hour ago',
                    120 => '2 hours ago',
                    360 => '6 hours ago',
                    720 => '12 hours ago',
                    1440 => '24 hours ago',
                    525600 => 'All Year',

                ]
            )->default(525600)
        ];
    }
}
