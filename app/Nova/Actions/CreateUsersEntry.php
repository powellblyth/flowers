<?php

namespace App\Nova\Actions;

use App\Models\Category;
use App\Models\Entrant;
use App\Models\Entry;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class CreateUsersEntry extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * The text to be used for the action's confirm button.
     *
     * @var string
     */
    public $confirmButtonText = 'Create Entry(ies)';
    public $name = 'Create Person\'s Entry';

    /**
     * Perform the action on the given models.
     *
     * @param \Laravel\Nova\Fields\ActionFields $fields
     * @param \Illuminate\Support\Collection $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {

        if ((int) ($fields['entrant_id'] ?? null) > 0) {
            $entrantId = (int) $fields['entrant_id'];
        } else {
            $user = new User();
            $user->first_name = $fields['first_name'];
            $user->last_name = $fields['family_name'];
            $user->email = $fields['email'];
            $user->address_1 = $fields['address_1'];
            $user->address_2 = $fields['address_2'];
            $user->address_town = $fields['address_town'];
            $user->telephone = $fields['telephone'];
            $user->postcode = $fields['postcode'];
            $user->can_email = $fields['can_email'];
            $user->can_phone = $fields['can_phone'];
            $user->can_retain_data = $fields['can_retain_data'];
            $user->save();

            $entrantId = $user->refresh()->entrants->first()->id;
        }
//        $entry->entrant_id = ;


        $models->each(function (Category $category) use ($fields, $entrantId) {
            Log::debug('eaching ' . $entrantId . ' ' . $fields['entrant_id']);
            // If there isn't an entry, then pervesely the check has succeeded
            try {
                $existingEntry = $category->entries()->where('entrant_id', $entrantId)->firstOrFail();
                Log::debug('failing because it exists');
                $this->markAsFailed($category);
            } catch (\Exception) {
                Log::debug('creating');
                $entry = new Entry();
                $entry->category()->associate($category);
                $entry->show()->associate($category->show);
                $entry->entrant_id = $entrantId;
                $entry->save();
            }
        });

        if ($fields['redirect_to'] === 'user') {
            $entrant = Entrant::find($entrantId);
            return Action::openInNewTab(config('nova.url') . '/resources/users/' . $entrant->user_id);
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
            Select::make(__('Entrant'), 'entrant_id')
                ->searchable()
                ->rules('nullable', 'exists:entrants,id')
                ->options(Entrant::where('is_anonymised', false)->orderBy('family_name')->orderBy('first_name')
                    ->get()
                    ->mapWithKeys(fn(Entrant $entrant) => [$entrant->id => $entrant->full_name])),
            Text::make(__('First Name'), 'first_name'),
            Text::make(__('Family Name'), 'family_name'),
            Text::make(__('Email Address'), 'email'),
            Text::make(__('Phone Number'), 'telephone'),
            Text::make('Address 1')->hideFromIndex(),
            Text::make('Address 2')->hideFromIndex(),
            Text::make('Town', 'address_town')->hideFromIndex(),
            Text::make('Postcode')->hideFromIndex(),
            Text::make('Telephone')->hideFromIndex(),
            Boolean::make(__('Can Retain Data'), 'can_retain_data'),
            Boolean::make(__('Can Email'), 'can_email'),
            Boolean::make(__('Can Telephone'), 'can_telephone'),
            Select::make(__('Redirect To'), 'redirect_to')
                ->options(['user' => 'Family Page', 'categories' => 'Stay'])
                ->withMeta(['value' => 'user']),
        ];
    }
}
