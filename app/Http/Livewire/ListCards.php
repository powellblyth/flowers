<?php

namespace App\Http\Livewire;

use App\Models\PaymentCard;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\PaymentMethod;
use Livewire\Component;
use Stripe\Exception\ApiConnectionException;

class ListCards extends Component
{
    public bool $hidden = true;
    protected $listeners = [
        'deleteCard' => 'handleDeleteCard',
    ];

    public function render()
    {
        $error = null;
        $paymentCards = null;

        try {
            /** @var User $user */
            $user = Auth::user();
            $paymentCards = $user->paymentMethods();
            foreach ($paymentCards as $cardData) {
                /** @var PaymentMethod $cardData */
                $paymentCard = $user->paymentCards()
                    ->firstOrNew([
                        'stripe_id' => $cardData->id,
                    ]);
                /** @var PaymentCard $paymentCard */
                $paymentCard->setFromStripe($cardData);
                $paymentCard->user()->associate($user);
                if ($paymentCard->isDirty()) {
                    try {
                        $paymentCard->save();
                    } catch (\Exception $e) {
                        dd($e);
                    }
                }
            }
        } catch (ApiConnectionException $e) {
            $error = $e->getMessage();
            if ('production' !== App::environment()) {
                $paymentCards = Subscription::getDummyCards();
            }
        } catch (\Exception $e) {
            dd($e);
        } finally {
            return view(
                'livewire.payment.list-payment-details',
                [
                    'payment_cards' => $paymentCards,
                    'error' => $error,
                ]
            );
        }
    }

    public function handleDeleteCard($cardId)
    {
        /** @var PaymentCard $paymentCard */
        try {
            $paymentCard = Auth::user()->paymentCards()->where('stripe_id', $cardId)->firstOrFail();
            $paymentCard->delete();
        }catch (ModelNotFoundException){
            dd('could not find card');
        }catch (\Exception){
            dd('waaa?');
        }
    }
}
