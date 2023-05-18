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
            ),
            1 => 
            array (
                'id' => 2,
                'judge_id' => 1,
                'judge_role_id' => 3,
                'show_id' => 6,
                'created_at' => '2022-07-02 11:42:56',
                'updated_at' => '2022-07-02 11:42:56',
            ),
            2 => 
            array (
                'id' => 3,
                'judge_id' => 2,
                'judge_role_id' => 1,
                'show_id' => 6,
                'created_at' => '2022-07-02 11:43:16',
                'updated_at' => '2022-07-02 11:43:16',
            ),
            3 => 
            array (
                'id' => 4,
                'judge_id' => 3,
                'judge_role_id' => 8,
                'show_id' => 6,
                'created_at' => '2022-07-02 20:50:54',
                'updated_at' => '2022-07-02 20:50:54',
            ),
            4 => 
            array (
                'id' => 5,
                'judge_id' => 3,
                'judge_role_id' => 7,
                'show_id' => 6,
                'created_at' => '2022-07-02 20:52:09',
                'updated_at' => '2022-07-02 20:52:09',
            ),
            5 => 
            array (
                'id' => 6,
                'judge_id' => 4,
                'judge_role_id' => 4,
                'show_id' => 6,
                'created_at' => '2022-07-04 18:18:19',
                'updated_at' => '2022-07-04 18:18:19',
            ),
            6 => 
            array (
                'id' => 7,
                'judge_id' => 2,
                'judge_role_id' => 5,
                'show_id' => 6,
                'created_at' => '2022-07-04 18:19:19',
                'updated_at' => '2022-07-04 18:19:19',
            ),
            7 => 
            array (
                'id' => 8,
                'judge_id' => 3,
                'judge_role_id' => 8,
                'show_id' => 8,
                'created_at' => '2023-05-01 20:55:26',
                'updated_at' => '2023-05-01 20:55:26',
            ),
            8 => 
            array (
                'id' => 9,
                'judge_id' => 4,
                'judge_role_id' => 4,
                'show_id' => 8,
                'created_at' => '2023-05-01 20:55:34',
                'updated_at' => '2023-05-01 20:55:34',
            ),
            9 => 
            array (
                'id' => 10,
                'judge_id' => 5,
                'judge_role_id' => 8,
                'show_id' => 8,
                'created_at' => '2023-05-01 20:55:50',
                'updated_at' => '2023-05-01 20:55:50',
            ),
        ));
        
        
    }
}