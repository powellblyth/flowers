<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class MembershipListRedirector extends Action
{
    use InteractsWithQueue, Queueable;

    public $showOnTableRow = false;
    public $showOnIndex = true;
    public $confirmButtonText = 'Membership Renewal Tool';
    public $name = 'Membership Renewal Tool';

    /**
     * Determine where the action redirection should be without confirmation.
     *
     * @var bool
     */
    public $withoutConfirmation = true;

    /**
     * Perform the action on the given models.
     *
     * @param ActionFields $fields
     * @param Collection $shows
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $shows): mixed
    {
        return Action::openInNewTab(route('members.list'));
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields(): array
    {
        return [];
    }
}
