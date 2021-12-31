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
            $entrant->save();
        }
        $users = User::where('can_retain_data', 0)
            ->where('is_anonymised', false)
            //->where('retain_data_opt_out', '<', $oneYearAgo->format('Y-m-d'))
            ->get();
        foreach ($users as $user) {
            $user->anonymise()->save();
            echo $user->full_name . "\n";
            $user->save();
        }
        parent::__construct();
    }
}
