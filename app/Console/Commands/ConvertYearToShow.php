<?php

namespace App\Console\Commands;

use App\Category;
use App\CupDirectWinner;
use App\Entry;
use App\Payment;
use App\Show;
use App\User;
use App\Entrant;
use Illuminate\Console\Command;

class ConvertYearToShow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:convertYearToShowId';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'One off, converts data to match show ID not year number';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $twentySeventeen = Show::firstOrCreate(['name' => '2017'], ['id' => 1, 'start_date' => '2017-07-08 14:15:00', 'ends_date' => '2017-07-08 17:00:00', 'late_entry_deadline' => '2017-07-06 12:00:59', 'entries_closed_deadline' => '2017-07-08 10:00:00', 'status' => 'passed']);
        $twentyEighteen  = Show::firstOrCreate(['name' => '2018'], ['id' => 2, 'start_date' => '2018-07-07 14:15:00', 'ends_date' => '2018-07-07 17:00:00', 'late_entry_deadline' => '2018-07-04 23:59:59', 'entries_closed_deadline' => '2018-07-07 10:00:00', 'status' => 'passed']);
        $twentNineteen   = Show::firstOrCreate(['name' => '2019'], ['id' => 3, 'start_date' => '2019-07-06 14:15:00', 'ends_date' => '2019-07-06 17:00:00', 'late_entry_deadline' => '2019-07-03 23:59:59', 'entries_closed_deadline' => '2019-07-06 10:00:00', 'status' => 'passed']);
        $twentTwenty     = Show::firstOrCreate(['name' => '2020'], ['id' => 4, 'start_date' => '2020-07-04 14:15:00', 'ends_date' => '2020-07-04 17:00:00', 'late_entry_deadline' => '2020-07-01 23:59:59', 'entries_closed_deadline' => '2020-07-04 10:00:00', 'status' => 'current']);

        $years = [2017 => $twentySeventeen, 2018 => $twentyEighteen, 2019 => $twentNineteen, 2020 => $twentTwenty];

        foreach ($years as $yearNumber => $show) {

            $this->info("\n".'Processing show '.$yearNumber ."\n--------------------------\n");

            $this->info( Entry::where('year', $yearNumber)
                ->whereNull('show_id')
                ->get()
                ->each(function (Entry $entry) use ($yearNumber, $show) {
                    $entry->show()->associate($show);
                    $entry->save();
                })->count() .' entries');


            $this->info(CupDirectWinner::where('year', $yearNumber)
                ->whereNull('show_id')
                ->get()
                ->each(function (CupDirectWinner $cupDirectWinner) use ($yearNumber, $show) {
                    $cupDirectWinner->show()->associate($show);
                    $cupDirectWinner->save();
                })->count() .' cup direct winners');

            $this->info(Category::where('year', $yearNumber)
                ->whereNull('show_id')
                ->get()
                ->each(function (Category $category) use ($yearNumber, $show) {
                    $category->show()->associate($show);
                    $category->save();
                })->count().' categories');

            $this->info(Payment::where('year', $yearNumber)
                ->whereNull('show_id')
                ->get()
                ->each(function (Payment $payment) use ($yearNumber, $show) {
                    $payment->show()->associate($show);
                    $payment->save();
                })->count() .' payments');
        }
    }
}