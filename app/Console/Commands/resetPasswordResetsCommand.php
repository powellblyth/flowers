<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class resetPasswordResetsCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:reset-expiry-tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Nasty shuffle for users';

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
        $users = User::where('email', '<>', '')
            ->where('password', '')
            ->where('can_retain_data', true)
            ->where('is_anonymised', false)
            ->where('can_email', true)
            ->get();
        foreach ($users as $user){
            echo $user->getName()."\n";
            echo 'UPDATE password_resets set created_at= \''.gmdate('Y-m-d H:i:s').'\' WHERE email=\''.$user->email.'\''."\n";
            \DB::statement('UPDATE password_resets set created_at= \''.gmdate('Y-m-d H:i:s').'\' WHERE email=\''.$user->email.'\'');

        }
        //
    }
}
