<?php

namespace App\Console\Commands;

use App\User;
use App\Entrant;
use Illuminate\Console\Command;

class AnonymiseEntrantsCommand extends Command {
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
    public function __construct() {
        parent::__construct();
    }

    public function anonymisePostcode(?string $postcode):?string {
        $newPostcode = null;
        if (!is_null($postcode) && !empty($postcode)) {
            $oldPostcode = explode(' ', trim($postcode));
            if (2 == count($oldPostcode)) {
                $newPostcode = $oldPostcode[0] . substr($oldPostcode[1], 0, 1);
            } else {
                $newPostcode = substr($postcode, 0, 5);

            }
        }
        return $newPostcode;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public
    function handle() {
        $newDate = new \DateTime();

        $oneYearAgo = $newDate->sub(new \DateInterval('P11M'));
        var_dump($oneYearAgo->format('Y-m-d'));
        $entrants = Entrant::where('can_retain_data', 0)
            ->where('is_anonymised', false)
            ->where('created_at', '<', '2018-08-08 00:00:00')->get();
        foreach ($entrants as $entrant) {
            $entrant->email = $entrant->id . '@' . $entrant->id . 'phs-anonymised' . rand(0, 100000) . '.com';
            $entrant->is_anonymised = true;
            $entrant->firstname = 'Anonymised';
            $entrant->familyname = 'Anonymised';
            $entrant->membernumber = null;
            $entrant->age = null;

    // some of these are legacy fields
            $entrant->telephone = null;
            $entrant->address = null;
            $entrant->address2 = null;
            $entrant->addresstown = null;
            $entrant->postcode = null;
            $entrant->retain_data_opt_in = null;
            $entrant->retain_data_opt_out = null;
            $entrant->email_opt_in = null;
            $entrant->email_opt_out = null;
            $entrant->can_email = false;
            $entrant->phone_opt_in = null;
            $entrant->phone_opt_out = null;
            $entrant->can_phone = false;
            $entrant->sms_opt_in = null;
            $entrant->sms_opt_out = null;
            $entrant->can_sms = false;
            $entrant->post_opt_in = null;
            $entrant->post_opt_out= null;
            $entrant->can_post = false;

            $entrant->created_at = null;
            echo $entrant->getName() . "\n";
            $entrant->save();
        }
        $users = User::where('can_retain_data', 0)
            ->where('is_anonymised', false)
            //->where('retain_data_opt_out', '<', $oneYearAgo->format('Y-m-d'))
            ->get();
        foreach ($users as $user) {
            $user->email = $user->id . '@' . $user->id . 'phs-anonymised' . rand(0, 100000) . '.com';
            $user->is_anonymised = true;
            $user->firstname = 'Anonymised';
            $user->lastname = 'Anonymised';
            $user->telephone = null;
            $user->address = null;
            $user->address2 = null;
            $user->addresstown = null;
            $user->retain_data_opt_in = null;
            $user->retain_data_opt_out = null;
            $user->email_opt_in = null;
            $user->email_opt_out = null;
            $user->can_email = false;
            $user->phone_opt_in = null;
            $user->phone_opt_out = null;
            $user->can_phone = false;
            $user->sms_opt_in = null;
            $user->sms_opt_out = null;
            $user->can_sms = false;
            $user->post_opt_in = null;
            $user->post_opt_out = null;
            $user->can_post = false;

            $user->postcode = $this->anonymisePostcode($user->postcode);
            $user->created_at = null;
            var_dump($user);
            echo $user->getName() . "\n";
            $user->save();
        }
        parent::__construct();
    }
}
