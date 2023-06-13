<?php

namespace App\Nova\Actions;

use App\Models\Entrant;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;

class RecordPayment extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * The text to be used for the action's confirm button.
     *
     * @var string
     */
    public $confirmButtonText = 'Store Payment';
    public $name = 'Store Family Payment';

    /**
     * The text to be used for the action's confirmation text.
     *
     * @var string
     */
    public $confirmText = 'Happy to store? enter in pounds';

    /**
     * Perform the action on the given models.
     *
     * @param Collection[\App\Models\User] $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {


        $models->each(function ($user) use ($fields) {
            if ($user instanceof Entrant) {
                $user = $user->user;
            }
            $payment = new Payment();
            $payment->amount = $fields['amount'] * 100;
            $payment->source = $fields['source'] ?? 'cash';
            $payment->user()->associate($user);
            $payment->save();
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
            Number::make(__('Amount in pounds'), 'amount')->step(0.01),
            Select::make(__('Method'), 'source')->options(Payment::getAllPaymentTypes()),
        ];
    }
}
