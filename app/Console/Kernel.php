<?php

namespace App\Console;

use App\Console\Commands\CheckExpiredMemberships;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
//        Commands\CreateNewYearDataCommand::class,
//        Commands\UpdateAgesCommand::class,
//        Commands\resetPasswordResetsCommand::class,
//        Commands\AnonymiseEntrantsCommand::class,
//        Commands\ConvertYearToShow::class,
//        Commands\SyncProductsCommand::class,
//        Commands\ScruffyCommand::class,
//        Commands\SendEmailToUnpasswordedPeopleCommand::class,
//        Commands\ConvertMembershipToMembershipModelCommand::class,
//        Commands\SendMailchimpSubscribesCommand::class,
//        CheckExpiredMemberships::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//         $schedule->command('inspire')->hourly();
        $schedule->command(CheckExpiredMemberships::class)->hourlyAt(12);
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
