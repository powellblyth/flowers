<?php

namespace App\Console\Commands;

use App\Models\MembershipPurchase;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckExpiredMemberships extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'membership:checkExpired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'expires any memberships that have passed their date';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        MembershipPurchase::where(
            'end_date',
            '<=',
            Carbon::now()->format('Y-m-d')
        )
            ->where('is_expired', 0)
            ->get()
            ->each(function (MembershipPurchase $membershipPurchase) {
                dump($membershipPurchase->user?->full_name ?? 'null');
                $membershipPurchase->is_expired = 1;
                $membershipPurchase->save();
            });

        return Command::SUCCESS;
    }
}
