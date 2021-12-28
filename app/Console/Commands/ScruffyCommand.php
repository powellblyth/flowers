<?php

namespace App\Console\Commands;

use App\Models\MembershipPurchase;
use App\Models\User;
use App\Notifications\MustChangePasswordNotification;
use Illuminate\Console\Command;

class ScruffyCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scruffy';

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
    public function handle() {
$purchases = MembershipPurchase::all();
$purchases->each(function (MembershipPurchase $purchase){
//    echo "UPDATE membership_purchases set YEAR='".$purchase->year."',  "
});
        config(['auth.passwords.users.expire' => 71280]);
//        $user = UserResource::where('email', 'toby.powellblyth@gmail.com')->first();
        $user = User::where('email', 'toby@powellblyth.com')->first();
        $token = \Password::getRepository()->create( $user );
        $user->password_reset_token = $token;
        if ($user->save())
        {
            $notification = new MustChangePasswordNotification($token, $user->firstname);
            $user->notify($notification);
        }
        var_dump($token);
//        $request = Request::create('password/email', 'POST' , ['email' => $user->email, 'csrf'=>csrf_token()]);
//        $this->info(app()['Illuminate\Contracts\Http\Kernel']->handle($request));


        //
    }
}
