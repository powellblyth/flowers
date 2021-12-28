<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\MustChangePasswordNotification;
use Illuminate\Console\Command;

class SendEmailToUnpasswordedPeopleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:invitenewuserstosetpasswords';

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
        config(['auth.passwords.users.expire' => 71280]);
        $users = User::where('email', '<>', '')
            ->where('password', '')
            ->where('can_retain_data', true)
            ->where('is_anonymised', false)
            ->where('can_email', true)
            ->get();

        foreach ($users as $user) {
            $token = \Password::getRepository()->create($user);
            $user->password_reset_token = $token;
            if ($user->save()) {
                $notification = new MustChangePasswordNotification($token, $user->firstname);
                echo $user->firstname ." " . $user->lastname . ": " .$user->email ."\n";
                $user->notify($notification);
            }        //
        }
    }
}
