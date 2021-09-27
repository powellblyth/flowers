<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use NZTim\Mailchimp\Mailchimp;
use NZTim\Mailchimp\Member;

class SendMailchimpSubscribesCommand extends Command
{
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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $listID = env('MC_LIST');
        $counter = 0;
        $mailchimp = new Mailchimp(env('MC_KEY'));

        $userList = User::where('email', '<>', '')
            ->whereNotNull('email')
            ->get();
        $userList->each(function (User $user) use ($mailchimp, $counter, $listID) {

            echo ++$counter . ':';
            $email = $user->safe_email;
            echo $user->firstname . ' ' . $user->lastname . ' ' . $email . "\n";

            if ($user->can_retain_data && $user->can_email) {
                $member = (new Member($email))->language('en');
                $member = $member->confirm(false)->status('subscribed');
                $mailchimp->addUpdateMember($listID, $member);
                echo "subscribing\n";
            } elseif ($mailchimp->check($listID, $email)) {
                // If the user is unsubscrbed, we cannot add them as unsubscribed
                // so we only change them if they already exist
                $mailchimp->unsubscribe($listID, $email);
                echo "doing unsubscribing\n";
            }
        });
    }

}
