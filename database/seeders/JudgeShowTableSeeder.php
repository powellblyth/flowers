<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JudgeShowTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('judge_show')->delete();
        
        \DB::table('judge_show')->insert(array (
            0 => 
            array (
                'id' => 1,
                'judge_id' => 1,
                'judge_role_id' => 2,
                'show_id' => 6,
                'created_at' => '2022-07-02 11:42:51',
                'updated_at' => '2022-07-02 11:42:51',
                'steward' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'judge_id' => 1,
                'judge_role_id' => 3,
                'show_id' => 6,
                'created_at' => '2022-07-02 11:42:56',
                'updated_at' => '2022-07-02 11:42:56',
                'steward' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'judge_id' => 2,
                'judge_role_id' => 1,
                'show_id' => 6,
                'created_at' => '2022-07-02 11:43:16',
                'updated_at' => '2022-07-02 11:43:16',
                'steward' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'judge_id' => 3,
                'judge_role_id' => 8,
                'show_id' => 6,
                'created_at' => '2022-07-02 20:50:54',
                'updated_at' => '2022-07-02 20:50:54',
                'steward' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'judge_id' => 3,
                'judge_role_id' => 7,
                'show_id' => 6,
                'created_at' => '2022-07-02 20:52:09',
                'updated_at' => '2022-07-02 20:52:09',
                'steward' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'judge_id' => 4,
                'judge_role_id' => 4,
                'show_id' => 6,
                'created_at' => '2022-07-04 18:18:19',
                'updated_at' => '2022-07-04 18:18:19',
                'steward' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'judge_id' => 2,
                'judge_role_id' => 5,
                'show_id' => 6,
                'created_at' => '2022-07-04 18:19:19',
                'updated_at' => '2022-07-04 18:19:19',
                'steward' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'judge_id' => 3,
                'judge_role_id' => 8,
                'show_id' => 8,
                'created_at' => '2023-05-01 20:55:26',
                'updated_at' => '2023-05-01 20:55:26',
                'steward' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'judge_id' => 4,
                'judge_role_id' => 4,
                'show_id' => 8,
                'created_at' => '2023-05-01 20:55:34',
                'updated_at' => '2023-05-01 20:55:34',
                'steward' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'judge_id' => 5,
                'judge_role_id' => 8,
                'show_id' => 8,
                'created_at' => '2023-05-01 20:55:50',
                'updated_at' => '2023-05-01 20:55:50',
                'steward' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'judge_id' => 7,
                'judge_role_id' => 2,
                'show_id' => 8,
                'created_at' => '2023-06-24 20:19:25',
                'updated_at' => '2023-06-24 20:19:25',
                'steward' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'judge_id' => 7,
                'judge_role_id' => 3,
                'show_id' => 8,
                'created_at' => '2023-06-24 20:19:32',
                'updated_at' => '2023-06-24 20:19:32',
                'steward' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'judge_id' => 6,
                'judge_role_id' => 5,
                'show_id' => 8,
                'created_at' => '2023-06-24 20:20:05',
                'updated_at' => '2023-06-24 20:20:05',
                'steward' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'judge_id' => 6,
                'judge_role_id' => 5,
                'show_id' => 8,
                'created_at' => '2023-06-24 20:20:20',
                'updated_at' => '2023-06-24 20:20:20',
                'steward' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'judge_id' => 8,
                'judge_role_id' => 7,
                'show_id' => 8,
                'created_at' => '2023-07-01 09:20:23',
                'updated_at' => '2023-07-01 09:20:23',
                'steward' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'judge_id' => 6,
                'judge_role_id' => 1,
                'show_id' => 8,
                'created_at' => '2023-07-01 09:31:43',
                'updated_at' => '2023-07-01 09:31:43',
                'steward' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'judge_id' => 12,
                'judge_role_id' => 7,
                'show_id' => 10,
                'created_at' => '2024-06-09 10:40:06',
                'updated_at' => '2024-06-09 20:28:01',
                'steward' => 'Mr. C Bayne',
            ),
            17 => 
            array (
                'id' => 18,
                'judge_id' => 7,
                'judge_role_id' => 3,
                'show_id' => 10,
                'created_at' => '2024-06-09 10:41:08',
                'updated_at' => '2024-06-09 20:28:14',
                'steward' => 'Mrs. L Mishan',
            ),
            18 => 
            array (
                'id' => 19,
                'judge_id' => 7,
                'judge_role_id' => 2,
                'show_id' => 10,
                'created_at' => '2024-06-09 10:41:15',
                'updated_at' => '2024-06-09 20:28:22',
                'steward' => 'Mrs. L Mishan',
            ),
            19 => 
            array (
                'id' => 20,
                'judge_id' => 10,
                'judge_role_id' => 8,
                'show_id' => 10,
                'created_at' => '2024-06-09 10:41:28',
                'updated_at' => '2024-06-09 10:41:28',
                'steward' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'judge_id' => 9,
                'judge_role_id' => 9,
                'show_id' => 10,
                'created_at' => '2024-06-09 10:41:39',
                'updated_at' => '2024-06-09 20:28:32',
                'steward' => 'Mrs. F Corner',
            ),
            21 => 
            array (
                'id' => 22,
                'judge_id' => 4,
                'judge_role_id' => 4,
                'show_id' => 10,
                'created_at' => '2024-06-09 10:41:53',
                'updated_at' => '2024-06-09 20:28:42',
                'steward' => 'Mrs. J Taylor',
            ),
            22 => 
            array (
                'id' => 23,
                'judge_id' => 13,
                'judge_role_id' => 1,
                'show_id' => 10,
                'created_at' => '2024-06-09 11:38:57',
                'updated_at' => '2024-06-09 20:28:56',
                'steward' => 'Mrs. J Bailey',
            ),
            23 => 
            array (
                'id' => 24,
                'judge_id' => 13,
                'judge_role_id' => 5,
                'show_id' => 10,
                'created_at' => '2024-06-09 11:39:04',
                'updated_at' => '2024-06-09 20:29:33',
                'steward' => 'Mrs. J Bailey',
            ),
        ));
        
        
    }
}