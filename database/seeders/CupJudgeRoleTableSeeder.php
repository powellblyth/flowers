<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CupJudgeRoleTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cup_judge_role')->delete();
        
        \DB::table('cup_judge_role')->insert(array (
            0 => 
            array (
                'id' => 1,
                'cup_id' => 14,
                'judge_role_id' => 7,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'cup_id' => 28,
                'judge_role_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'cup_id' => 28,
                'judge_role_id' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'cup_id' => 28,
                'judge_role_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'cup_id' => 27,
                'judge_role_id' => 5,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'cup_id' => 26,
                'judge_role_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'cup_id' => 25,
                'judge_role_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'cup_id' => 24,
                'judge_role_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'cup_id' => 18,
                'judge_role_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'cup_id' => 17,
                'judge_role_id' => 4,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'cup_id' => 16,
                'judge_role_id' => 9,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'cup_id' => 15,
                'judge_role_id' => 9,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'cup_id' => 29,
                'judge_role_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'cup_id' => 29,
                'judge_role_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'cup_id' => 29,
                'judge_role_id' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'cup_id' => 11,
                'judge_role_id' => 2,
                'created_at' => '2024-06-18 22:30:51',
                'updated_at' => '2024-06-18 22:30:55',
            ),
            16 => 
            array (
                'id' => 17,
                'cup_id' => 12,
                'judge_role_id' => 1,
                'created_at' => '2024-06-18 22:31:47',
                'updated_at' => '2024-06-18 22:31:49',
            ),
        ));
        
        
    }
}