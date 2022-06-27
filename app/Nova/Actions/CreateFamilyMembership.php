<?php

namespace App\Nova\Actions;

use App\Models\Membership;
use App\Models\MembershipPurchase;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
class CreateFamilyMembership extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * The text to be used for the action's confirm button.
     *
     * @var string
     */
    public $confirmButtonText = 'Create Family Membership(s)';
    public $name = 'Create Family Membership(s)';

    /**
     * The text to be used for the action's confirmation text.
     *
     * @var string
     */
    public $confirmText = 'Are you sure you want to create this Single membership?';

    /**
     * Perform the action on the given models.
     *
     * @param ActionFields $fields
     * @param Collection[\App\Models\User] $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $membershipType = Membership::whereAppliesTo(Membership::APPLIES_TO_USER)->firstOrFail();


        $models->each(function (User $user) use ($fields, $membershipType) {
            // Don't do it if the user has a
            if (0 === $user->membershipPurchases()->active()->count()) {
                $membershipPurchase = MembershipPurchase::create(
                    [
                        'type' => $membershipType->applies_to,
                        'amount' => $membershipType->price_gbp,
                        'year' => date('Y'),
                        'start_date' => Carbon::now(),
                        'end_date' => Membership::getRenewalDate(),
                    ],
                );

                $user->membershipPurchases()->save($membershipPurchase);
            }
        });
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
