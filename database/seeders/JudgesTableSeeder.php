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
            5 => 
            array (
                'id' => 6,
                'name' => 'Hazel Chant',
                'description' => NULL,
                'cv' => NULL,
                'created_at' => '2023-06-24 20:18:52',
                'updated_at' => '2023-06-24 20:19:53',
                'display_name' => 'Mrs. H. Chant',
                'address' => NULL,
                'telephone' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Gordon Cooper',
                'description' => NULL,
                'cv' => NULL,
                'created_at' => '2023-06-24 20:19:07',
                'updated_at' => '2023-06-24 20:19:07',
                'display_name' => 'Mr. G. Cooper',
                'address' => 'flashgordoncooper@hotmail.com',
                'telephone' => '07927660958',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Photography',
                'description' => NULL,
                'cv' => NULL,
                'created_at' => '2023-07-01 09:17:40',
                'updated_at' => '2023-07-01 09:17:40',
                'display_name' => 'Photography Judge',
                'address' => NULL,
                'telephone' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Vivienne Sharratt',
                'description' => NULL,
                'cv' => NULL,
                'created_at' => '2024-06-09 10:37:20',
                'updated_at' => '2024-06-09 10:37:20',
                'display_name' => 'Mrs V Sharratt',
                'address' => 'VIVSHARRATT@ICLOUD.COM',
                'telephone' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Eugenie Olding',
                'description' => NULL,
                'cv' => NULL,
                'created_at' => '2024-06-09 10:37:55',
                'updated_at' => '2024-06-09 10:37:55',
                'display_name' => 'Mrs E Olding',
                'address' => 'EUGENIE@OLDING.COM',
                'telephone' => '07900984958',
            ),
            10 => 
            array (
                'id' => 12,
                'name' => 'Carmen Drake and Philip Quarry',
                'description' => NULL,
                'cv' => NULL,
                'created_at' => '2024-06-09 10:39:42',
                'updated_at' => '2024-06-09 10:39:42',
                'display_name' => 'Mrs C Drake & Mr P Quarry',
                'address' => 'carmen.dragota@gmail.com
philip.quarry@btinternet.com',
                'telephone' => NULL,
            ),
            11 => 
            array (
                'id' => 13,
                'name' => 'Richard Hilson',
                'description' => NULL,
                'cv' => NULL,
                'created_at' => '2024-06-09 11:38:40',
                'updated_at' => '2024-06-09 11:38:40',
                'display_name' => 'Mr R. Hilson',
                'address' => 'rwh@rlhilson.plus.com',
                'telephone' => NULL,
            ),
        ));
        
        
    }
}