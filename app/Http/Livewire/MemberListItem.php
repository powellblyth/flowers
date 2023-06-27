<?php

namespace App\Http\Livewire;

use App\Http\Controllers\MembershipPurchaseController;
use App\Models\Entrant;
use App\Models\Membership;
use App\Models\MembershipPurchase;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MemberListItem extends Component
{
    public User $member;
    public ?string $email;
    public ?string $membership_type = null;
    public ?string $payment_type = null;
    public bool $can_retain_data;

    public bool $can_email;
    public ?string $successMessage = null;
    public ?string $failedMessage = null;
    public bool $failed = false;

    public ?MembershipPurchase $latestMembershipPurchase = null;
    public ?string $filter = null;
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        $this->email = $this->member->email;
        $this->can_email = $this->member->can_email;
        $this->can_retain_data = $this->member->can_retain_data;
        $this->membership_type = $this->member->getLatestMembershipPurchase()?->type;
        $this->payment_type = null;
    }

    public function render(): Factory|View|Application
    {
        $this->latestMembershipPurchase = $this->member->getLatestMembershipPurchase();

        return view('livewire.member-list-item');
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function renew()
    {
        $this->failedMessage = null;
        $this->successMessage = null;
        $this->failed = false;

        if (!$this->membership_type || !$this->payment_type) {
            $this->failedMessage = 'You must select a payment method and membership type';
            $this->failed = true;
            return;
        }
        $entrant = null;
        if (Membership::APPLIES_TO_ENTRANT == $this->membership_type) {
            $entrant = $this->member->entrants->first();
        }

        DB::beginTransaction();
        // Validate the request...
        $optIns = ['retain_data', 'email'];
        $optInRequest = [];

        /* @todo this should be a method on the model or something */
        foreach ($optIns as $optin) {
            if ($this->{'can_' . $optin}) {
                $optInRequest['can_' . $optin] = 1;
                $optInRequest[$optin . '_opt_in'] = Carbon::now();
            } else {
                $optInRequest['can_' . $optin] = 0;
                $optInRequest[$optin . '_opt_out'] = Carbon::now();
            }
        }

        if (!$this->member->update(
            array_merge(
                ['email' => $this->email],
                $optInRequest
            )
        )) {
            DB::rollBack();
            $this->failed = true;
            $this->failedMessage = 'Could not save Family Manager';
            return;

//            return redirect()->back()->withErrors(['msg' => 'Could not save user']);
        }

        $payment = new Payment();
        $payment->user()->associate($this->member);
        $payment->amount = MembershipPurchaseController::getAmount($this->membership_type);
        $payment->source = $this->payment_type;

        if ($entrant instanceof Entrant) {
            $payment->entrant()->associate($entrant);
        }
        if (!$payment->save()) {
            DB::rollBack();
            $this->failed = true;
            $this->failedMessage = 'Could not save Payment';
            return;
        }

        $membershipPurchase = new MembershipPurchase();
        $membershipPurchase->type = $this->membership_type;
        $membershipPurchase->amount = MembershipPurchaseController::getAmount($this->membership_type);

        if ($entrant instanceof Entrant) {
            $membershipPurchase->entrant()->associate($entrant);
        }
        $membershipPurchase->user()->associate($this->member);
        $membershipPurchase->end_date = Membership::getRenewalDate();
        $membershipPurchase->start_date = Carbon::now();

        // Todo record payment here
        if ($membershipPurchase->save()) {
            DB::commit();
            $this->failed = false;
            $this->successMessage = 'Membership Saved';
            $this->emit('refreshComponent');
        }
        DB::rollBack();
    }
}
