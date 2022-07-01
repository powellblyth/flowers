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
                'name' => 'Mr R. Bailey',
                'description' => '',
                'cv' => '',
                'created_at' => '2022-06-29 21:23:37',
                'updated_at' => '2022-06-29 21:23:37',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Mrs P. Edwards',
                'description' => '-',
                'cv' => '-',
                'created_at' => '2022-06-29 21:23:37',
                'updated_at' => '2022-06-29 21:23:37',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Mr J. Rounce',
                'description' => '-',
                'cv' => '-',
                'created_at' => '2022-06-29 21:23:37',
                'updated_at' => '2022-06-29 21:23:37',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Mrs C. Tudway',
                'description' => '-',
                'cv' => '-',
                'created_at' => '2022-06-29 21:23:37',
                'updated_at' => '2022-06-29 21:23:37',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Mr C. Bayne',
                'description' => '-',
                'cv' => '-',
                'created_at' => '2022-06-29 21:23:37',
                'updated_at' => '2022-06-29 21:23:37',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Mrs P. Edwards',
                'description' => '-',
                'cv' => '-',
                'created_at' => '2022-06-29 21:23:37',
                'updated_at' => '2022-06-29 21:23:37',
            ),
        ));
        
        
    }
}
