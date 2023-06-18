<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\MailChimpService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class syncUserToMailChimpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public User $user)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!is_null($this->user?->email) && !empty($this->user?->email)) {
            /** @var MailChimpService $mailchimp */
            $mailchimp = app(MailChimpService::class);
            Log::debug('user  ' . $this->user->id . ' saving');

            // We saved the user, if these pertinent fields have changed then
            // Check if we can resubscribe or not
            // This safe_email means that on TEST we never actually manipulate a real address
            $email = $this->user->safe_email;

            Log::debug($this->user->full_name . ' ' . $email . ' (' . $this->user->email . ') has changed');
            if ($this->user->can_retain_data && $this->user->can_email) {

                $currentMembership = $this->user
                    ->membershipPurchases()
                    ->mostRecentFirst()
                    ->active()
                    ->first();

                $mailchimp->subscribe(
                    $email,
                    $currentMembership?->type ?? 'none',
                    $this->user->is_committee,
                    $this->user->first_name,
                    $this->user->last_name,
                );
            } else {
                $mailchimp->unsubscribe($email);
            }
        }
    }
}
