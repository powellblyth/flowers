<?php

namespace App\Nova\Actions;

use App\Jobs\CreateNewShowJob;
use App\Models\Show;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Text;

class DuplicateShowAction extends Action
{
    use InteractsWithQueue, Queueable;

    public $showOnTableRow = true;
    public $showOnIndex = false;
    public $confirmButtonText = 'Duplicate!';
    public $name ='Duplicate Show';
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
    public $confirmText = 'Are you sure you want to duplicate?';

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            $show = new Show();

            $show->name = $fields->name;
            $show->start_date = $fields->start_date;
            $show->ends_date = $fields->ends_date;
            $show->late_entry_deadline = $fields->late_entry_deadline;
            $show->entries_closed_deadline = $fields->entries_closed_deadline;
            if ($show->save()) {
                dispatch(new CreateNewShowJob($model, $show));
                return Action::message('It worked!');

            } else {
                return Action::message('It Failed!');
            }
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Text::make('Name')->rules('max:255')->required(),
            DateTime::make('Start Date')->required(),
            DateTime::make('End Date', 'ends_date')->required(),
            DateTime::make('Late Entry Deadline')->required(),
            DateTime::make('Entries Closed Deadline')->required(),
        ];
    }
}
