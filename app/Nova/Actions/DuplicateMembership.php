<?php

namespace App\Nova\Actions;

use App\Models\Membership;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class DuplicateMembership extends Action
{
    use InteractsWithQueue, Queueable;

    public $showOnTableRow = true;
    public $showOnIndex = false;
    public $confirmButtonText = 'Duplicate!';
    public $name = 'Duplicate Membership';
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
        foreach ($models as $membership) {
            /**
             * @var Membership $membership
             */
            $membership->replicate();
            $membership->label = $membership->label . ' copy';
            $membership->sku = 'COPY_' . $membership->sku;
            $membership->description = 'copy ' . $membership->description;
            if ($membership->save()) {
                return Action::message('It worked!');

            } else {
                return Action::danger('It Failed!');
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
        ];
    }
}
