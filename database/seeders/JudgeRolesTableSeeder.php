<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JudgeRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('judge_roles')->delete();
        
        \DB::table('judge_roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'label' => 'Flowers',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'label' => 'Vegetables',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'label' => 'Fruit',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'label' => 'Cookery',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'label' => 'Floral Art',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'label' => 'Cooking',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'label' => 'Photography',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'label' => 'Arts and Crafts',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'label' => 'Art',
                'created_at' => '2023-05-01 21:21:21',
                'updated_at' => '2023-05-01 21:21:21',
            ),
        ));
        
        
    }
}