<?php

namespace App\Console\Commands;

use App\Models\User;
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
$user = User::first();
$user->merge(User::find(10));
    }
}
