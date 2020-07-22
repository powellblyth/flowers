<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class UpdateAgesCommand extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:update-ages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates all children\'s ages by one year';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        DB::table('entrants')->whereNotNull('age')->increment('age', 1);
//        DB::Raw(' UPDATE entrants set `age`=`age`+1 where Age IS NOT NULL ');
//        DB::Update('entrants', );
    }
}
