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
                'id' => 1,
                'name' => '2017',
                'slug' => '2017',
                'start_date' => '2017-07-08 14:15:00',
                'ends_date' => '2017-07-08 17:00:00',
                'late_entry_deadline' => '2017-07-06 12:00:59',
                'entries_closed_deadline' => '2017-07-08 10:00:00',
                'status' => 'passed',
                'created_at' => '2021-07-07 23:53:42',
                'updated_at' => '2021-07-07 23:53:42',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '2018',
                'slug' => '2018',
                'start_date' => '2018-07-07 14:15:00',
                'ends_date' => '2018-07-07 17:00:00',
                'late_entry_deadline' => '2018-07-04 23:59:59',
                'entries_closed_deadline' => '2018-07-07 10:00:00',
                'status' => 'passed',
                'created_at' => '2021-07-07 23:53:42',
                'updated_at' => '2021-07-07 23:53:42',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => '2019',
                'slug' => '2019',
                'start_date' => '2019-07-06 14:15:00',
                'ends_date' => '2019-07-06 17:00:00',
                'late_entry_deadline' => '2019-07-03 23:59:59',
                'entries_closed_deadline' => '2019-07-06 10:00:00',
                'status' => 'passed',
                'created_at' => '2021-07-07 23:53:42',
                'updated_at' => '2021-07-07 23:53:42',
            ),
            3 => 
            array (
                'id' => 5,
                'name' => '2021 mini show',
                'slug' => '2021',
                'start_date' => '2021-07-03 11:00:00',
                'ends_date' => '2021-07-07 16:00:00',
                'late_entry_deadline' => '2021-07-03 08:00:00',
                'entries_closed_deadline' => '2021-07-03 08:00:00',
                'status' => 'passed',
                'created_at' => '2021-07-08 00:51:32',
                'updated_at' => '2022-04-21 01:01:28',
            ),
            4 => 
            array (
                'id' => 6,
                'name' => '2022',
                'slug' => '2022',
                'start_date' => '2022-07-09 13:15:00',
                'ends_date' => '2022-07-09 16:00:00',
                'late_entry_deadline' => '2022-07-08 17:00:00',
                'entries_closed_deadline' => '2022-07-09 09:00:00',
                'status' => 'current',
                'created_at' => '2022-03-18 18:10:50',
                'updated_at' => '2022-04-18 19:15:45',
            ),
            5 => 
            array (
                'id' => 8,
                'name' => '2023',
                'slug' => '2023',
                'start_date' => '2023-07-01 12:30:00',
                'ends_date' => '2023-07-01 16:00:00',
                'late_entry_deadline' => '2023-07-01 09:00:00',
                'entries_closed_deadline' => '2023-07-01 09:00:00',
                'status' => 'current',
                'created_at' => '2023-04-26 20:55:07',
                'updated_at' => '2023-04-27 13:03:05',
            ),
            6 => 
            array (
                'id' => 9,
                'name' => 'copy of 22 show includeing accidentally changes sections',
                'slug' => NULL,
                'start_date' => '2023-04-26 11:00:00',
                'ends_date' => '2023-04-26 11:00:00',
                'late_entry_deadline' => '2023-04-26 11:00:00',
                'entries_closed_deadline' => '2023-04-26 11:00:00',
                'status' => 'planned',
                'created_at' => '2023-04-26 21:22:09',
                'updated_at' => '2023-04-26 21:22:09',
            ),
        ));
        
        
    }
}