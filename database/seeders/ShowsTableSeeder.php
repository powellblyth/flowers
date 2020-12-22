<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ShowsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('shows')->delete();

        \DB::table('shows')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'name' => '2017',
                    'start_date' => '2017-07-08 14:15:00',
                    'ends_date' => '2017-07-08 17:00:00',
                    'late_entry_deadline' => '2017-07-06 12:00:59',
                    'entries_closed_deadline' => '2017-07-08 10:00:00',
                    'status' => 'passed',
                    'created_at' => '2020-05-04 12:16:10',
                    'updated_at' => '2020-05-04 12:16:10',
                ),
            1 =>
                array(
                    'id' => 2,
                    'name' => '2018',
                    'start_date' => '2018-07-07 14:15:00',
                    'ends_date' => '2018-07-07 17:00:00',
                    'late_entry_deadline' => '2018-07-04 23:59:59',
                    'entries_closed_deadline' => '2018-07-07 10:00:00',
                    'status' => 'passed',
                    'created_at' => '2020-05-04 12:16:10',
                    'updated_at' => '2020-05-04 12:16:10',
                ),
            2 =>
                array(
                    'id' => 3,
                    'name' => '2019',
                    'start_date' => '2019-07-06 14:15:00',
                    'ends_date' => '2019-07-06 17:00:00',
                    'late_entry_deadline' => '2019-07-03 23:59:59',
                    'entries_closed_deadline' => '2019-07-06 10:00:00',
                    'status' => 'passed',
                    'created_at' => '2020-05-04 12:16:10',
                    'updated_at' => '2020-05-04 12:16:10',
                ),
            3 =>
                array(
                    'id' => 4,
                    'name' => '2020',
                    'start_date' => '2020-07-04 14:15:00',
                    'ends_date' => '2020-07-04 17:00:00',
                    'late_entry_deadline' => '2020-07-01 23:59:59',
                    'entries_closed_deadline' => '2020-07-04 10:00:00',
                    'status' => 'current',
                    'created_at' => '2020-05-04 12:16:10',
                    'updated_at' => '2020-05-04 12:16:10',
                ),
        ));


    }
}
