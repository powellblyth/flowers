<?php

namespace App\Console\Commands;

use App\Models\Entrant;
use App\Models\User;
use Illuminate\Console\Command;

class AnonymiseEntrantsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:anonymise-entrants';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Anonymises all users and entrants if they are not opted in to retain';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $newDate = new \DateTime();

        $oneYearAgo = $newDate->sub(new \DateInterval('P11M'));
        var_dump($oneYearAgo->format('Y-m-d'));
        $entrants = Entrant::where('can_retain_data', 0)
            ->where('is_anonymised', false)
            ->where('created_at', '<', '2018-08-08 00:00:00')->get();
        foreach ($entrants as $entrant) {
            $entrant->anonymise()->save();
//            echo $entrant->getName() . "\n";
            $entrant->save();
        }
        $users = User::where('can_retain_data', 0)
            ->where('is_anonymised', false)
            //->where('retain_data_opt_out', '<', $oneYearAgo->format('Y-m-d'))
            ->get();
        foreach ($users as $user) {
            $user->anonymise()->save();
            var_dump($user);
            echo $user->getName() . "\n";
            $user->save();
        }
        parent::__construct();
    }
}
