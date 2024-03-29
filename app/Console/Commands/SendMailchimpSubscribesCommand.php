<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use NZTim\Mailchimp\Exception\MailchimpBadRequestException;
use NZTim\Mailchimp\Exception\MailchimpException;
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
     * @throws MailchimpException
     */
    public function handle()
    {
        $listID = config('flowers.mailchimp.mailing_list_id');
        $counter = 0;
        $mailchimp = new Mailchimp(config('flowers.mailchimp.mailing_list_key'));

        $userList = User::where('email', '<>', '')
            ->whereNotNull('email')
            ->orderBy('updated_at', 'DESC')
            ->get();
        $userList->each(function (User $user) use ($mailchimp, $counter, $listID) {

            echo ++$counter . ':';
            $email = $user->safe_email;
            echo $user->full_name . ' ' . $email . "\n";


            try {
                if ($user->can_retain_data && $user->can_email) {
                    $member = (new Member($email))->language('en');
                    $member = $member->confirm(false)->status('subscribed');
                    $mailchimp->addUpdateMember($listID, $member);
                    echo "subscribing\n";
                } elseif ($mailchimp->check($listID, $email)) {
                    // If the user is unsubscribed, we cannot add them as unsubscribed
                    // so we only change them if they already exist
                    $mailchimp->unsubscribe($listID, $email);
                    echo "doing unsubscribing\n";
                }
            } catch
            (MailchimpBadRequestException $e) {
                echo $e->getMessage();
                Log::error($e->getMessage());
            }
        }
        );
    }

}
