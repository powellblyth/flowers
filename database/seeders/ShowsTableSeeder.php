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
        
        \DB::table('shows')->insert(array (
            0 => 
            array (
                'created_at' => '2021-07-07 23:53:42',
                'ends_date' => '2017-07-08 17:00:00',
                'entries_closed_deadline' => '2017-07-08 10:00:00',
                'id' => 1,
                'late_entry_deadline' => '2017-07-06 12:00:59',
                'name' => '2017',
                'start_date' => '2017-07-08 14:15:00',
                'status' => 'passed',
                'updated_at' => '2021-07-07 23:53:42',
            ),
            1 => 
            array (
                'created_at' => '2021-07-07 23:53:42',
                'ends_date' => '2018-07-07 17:00:00',
                'entries_closed_deadline' => '2018-07-07 10:00:00',
                'id' => 2,
                'late_entry_deadline' => '2018-07-04 23:59:59',
                'name' => '2018',
                'start_date' => '2018-07-07 14:15:00',
                'status' => 'passed',
                'updated_at' => '2021-07-07 23:53:42',
            ),
            2 => 
            array (
                'created_at' => '2021-07-07 23:53:42',
                'ends_date' => '2019-07-06 17:00:00',
                'entries_closed_deadline' => '2019-07-06 10:00:00',
                'id' => 3,
                'late_entry_deadline' => '2019-07-03 23:59:59',
                'name' => '2019',
                'start_date' => '2019-07-06 14:15:00',
                'status' => 'passed',
                'updated_at' => '2021-07-07 23:53:42',
            ),
            3 => 
            array (
                'created_at' => '2021-07-08 00:51:32',
                'ends_date' => '2021-07-07 16:00:00',
                'entries_closed_deadline' => '2021-07-03 08:00:00',
                'id' => 5,
                'late_entry_deadline' => '2021-07-03 08:00:00',
                'name' => '2021 mini show',
                'start_date' => '2021-07-03 11:00:00',
                'status' => 'passed',
                'updated_at' => '2021-07-08 00:51:32',
            ),
            4 => 
            array (
                'created_at' => '2022-03-18 18:10:50',
                'ends_date' => '2022-07-09 16:00:00',
                'entries_closed_deadline' => '2022-07-09 09:00:00',
                'id' => 6,
                'late_entry_deadline' => '2022-07-08 17:00:00',
                'name' => '2022',
                'start_date' => '2022-07-09 13:15:00',
                'status' => 'current',
                'updated_at' => '2022-03-18 18:10:50',
            ),
        ));
        
        
    }
}