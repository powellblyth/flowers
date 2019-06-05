<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use NZTim\Mailchimp\Mailchimp;
use NZTim\Mailchimp\Member;
class SendMailchimpSubscribesCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mailchimp:subscribeusers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $listID = env('MC_LIST');
        $counter = 0;
        $mailchimp = new Mailchimp(env('MC_KEY'));
//        var_dump($mailchimp->api('GET','/lists/'.$listID.'/segments'));
//        die();

        $userList = User::where('email', '<>', '')
            ->whereNotNull('email')
            ->get();
        foreach ($userList as $user) {
            echo ++$counter . ':';
            $email = $user->getSafeEmail();
            echo $user->firstname . ' ' . $user->lastname . ' ' . $email . "\n";
            $member = (new Member($email))->language('en');
            if ($user->can_retain_data && $user->can_email) {
                $member = $member->confirm(false)->status('subscribed');
                $mailchimp->addUpdateMember($listID, $member);
                echo "subscribing\n";

            }
            // If the user is unsubscrbed, we cannot add them as unsubscribed
            // so we only change them if they already exist
            elseif ($mailchimp->check($listID, $email)) {
                $member = $member->status('unsubscribed');
                $mailchimp->unsubscribe($listID, $email);
                echo "doing unsubscribing\n";
            }
//            var_dump($member);
            if (20  <= $counter ){break;}
        }
//        var_dump($mailchimp->getLists());
        //
//        var_dump($mailchimp->check($listID, 'toby.powellblyth@gmail.com'));
//        var_dump($mailchimp->check($listID, 'toby@powellblyth.com'));
    }

}
