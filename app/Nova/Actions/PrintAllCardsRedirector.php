<?php

namespace App\Nova\Actions;

use App\Models\Show;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;

class PrintAllCardsRedirector extends Action
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
     * The text to be used for the action's confirmation text.
     *
     * @var string
     */
    public $confirmText = 'Open Print All Cards?';

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $shows)
    {
        $params = ['since' => $fields->since];
        // Can only do one at once.
        foreach ($shows as $model) {
            switch (get_class($model)) {
                case Show::class:
                    $params['users'] = $model;
                    break;
                case User::class:
                    $params['users'] = array_merge($params['users'] ?? [], [$model->id]);
                    break;
            };

        }
        return Action::openInNewTab(route('entries.printall', $params));
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Select::make('Since')->options(
                [
                    5 => '5 minutes',
                    10 => '10 minutes',
                    30 => '30 minutes',
                    60 => '1 hour',
                    360 => '6 hours ago',
                    1440 => '24 hours ago',
                    525600 => 'All Year',

                ]
            )->default(525600)
        ];
    }
}
