<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JudgesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('judges')->delete();
        
        \DB::table('judges')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Neil Hope',
                'description' => NULL,
                'cv' => NULL,
                'created_at' => '2022-07-02 11:21:33',
                'updated_at' => '2022-07-02 11:42:29',
                'display_name' => 'Mr. N Hope',
                'address' => '53 Frogmore Park Drive
Blackwater
Camberley
Surrey
GU17 0PJ',
            'telephone' => 'Tel 01276 35217 (yes 5 digits!)

Mob 07761664567',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Daphne Hope',
                'description' => NULL,
                'cv' => NULL,
                'created_at' => '2022-07-02 11:22:06',
                'updated_at' => '2022-07-02 11:41:42',
                'display_name' => 'Mrs. D Hope',
                'address' => '53 Frogmore Park Drive
Blackwater
Camberley
Surrey
GU17 0PJ',
            'telephone' => '01276 35217 (yes 5 digits!)',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Celia Tudway',
                'description' => NULL,
                'cv' => NULL,
                'created_at' => '2022-07-02 11:59:56',
                'updated_at' => '2022-07-02 11:59:56',
                'display_name' => 'Mrs. C Tudway',
                'address' => NULL,
                'telephone' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Jonathan Rounce',
                'description' => NULL,
                'cv' => NULL,
                'created_at' => '2022-07-04 18:17:56',
                'updated_at' => '2022-07-04 18:17:56',
                'display_name' => 'Mr. J. Rounce',
                'address' => NULL,
                'telephone' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Francis Taylor',
                'description' => 'Art teacher',
                'cv' => NULL,
                'created_at' => '2023-05-01 20:54:35',
                'updated_at' => '2023-05-01 20:54:35',
                'display_name' => 'Mrs F Taylor',
                'address' => NULL,
                'telephone' => NULL,
            ),
        ));
        
        
    }
}