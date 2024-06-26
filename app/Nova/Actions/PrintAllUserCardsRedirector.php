<?php

namespace App\Nova\Actions;

use App\Models\Show;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;

class PrintAllUserCardsRedirector extends Action
{
    use InteractsWithQueue, Queueable;

    public $showOnTableRow = true;
    public $showOnIndex = false;
    public $confirmButtonText = 'Print Card!';
    public $name = 'Print Cards';

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
    public $confirmText = 'Open Print All Cards?';

    /**
     * Perform the action on the given models.
     *
     * @return array|string[]
     */
    public function handle(ActionFields $fields, Collection $users)
    {
        // Can only do one at once.
        return Action::openInNewTab(
            route(
                'users.print',
                [
                    'users' => $users->pluck('id')->toArray(),
                    'show' => Show::public()->newestFirst()->first(),
                    'since' => $fields->since,
                ]
            )
        );
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
