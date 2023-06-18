<?php

namespace App\Console\Commands;

use App\Jobs\syncUserToMailChimpJob;
use App\Models\User;
use Illuminate\Console\Command;

class ResyncMembersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'members:resyncAllToMailChimp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'resyncs all users to allow refresh of new facets, new data etc.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        User::all()->each(function (User $user) {
            dump($user?->full_name ?? 'null');
            syncUserToMailChimpJob::dispatch($user);
        });

        return Command::SUCCESS;
    }
}
