<?php

namespace App\Nova\Actions;

use App\Models\Show;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;

class PrintAllUserCardsA5Redirector extends Action
{
    use InteractsWithQueue, Queueable;

    public $showOnTableRow = true;
    public $showOnIndex = false;
    public $confirmButtonText = 'Print Card A5!';
    public $name = 'Print Cards in A5';

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
     * @return array|string[]
     */
    public function handle(ActionFields $fields, Collection $users)
    {
        // Can only do one at once.
        return Action::openInNewTab(
            route(
                'users.printA5',
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
