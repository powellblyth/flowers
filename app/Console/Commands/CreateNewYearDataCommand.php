<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateNewYearDataCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:create-new-year-data {year-from} {year-to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'copies all the data from one year to another';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {


    }
}
