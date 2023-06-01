<?php

namespace App\Nova\Actions;

use App\Models\Show;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class PrintAllJudgingSheetsRedirector extends Action
{
    use InteractsWithQueue, Queueable;

    public $showOnTableRow = true;
    public $showOnIndex = false;
    public $confirmButtonText = 'Print Judging Sheets!';
    public $name = 'Print Sheets';

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
    public $confirmText = 'Open Print All Judging sheets?';

    /**
     * Perform the action on the given models.
     *
     * @return array|string[]
     */
    public function handle(ActionFields $fields, Collection $judges): array
    {
        return Action::openInNewTab(
            route(
                'judges.printSheets',
                ['show' => Show::public()->newestFirst()->first(), 'judge' => $judges->first()]
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
        ];
    }
}
