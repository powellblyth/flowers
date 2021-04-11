<?php

namespace App\Console;

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
        Commands\CreateNewYearDataCommand::class,
        Commands\UpdateAgesCommand::class,
        Commands\resetPasswordResetsCommand::class,
        Commands\AnonymiseEntrantsCommand::class,
        Commands\ConvertYearToShow::class,
        Commands\SendMailchimpSubscribesCommand::class,
        Commands\ScruffyCommand::class,
        Commands\SendEmailToUnpasswordedPeopleCommand::class,

    ];

    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('mailchimp:subscribeusers')->cron('*/5 9,11,12,13,15,17,19,21 * * *');
//         $schedule->command('inspire')->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
