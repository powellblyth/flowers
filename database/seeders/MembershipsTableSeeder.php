<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MembershipsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('memberships')->delete();

        \DB::table('memberships')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'sku' => 'FAMILY',
                    'stripe_id' => 'price_1KvFnZHJv0e8AgMdCw2E9pTP',
                    'label' => 'Family Membership',
                    'description' => 'Family membership of the Petersham Horti',
                    'price_gbp' => 500,
                    'applies_to' => 'user',
                    'created_at' => '2020-07-21 11:19:06',
                    'updated_at' => '2020-07-21 11:19:06',
                    'deleted_at' => null,
                ),
            1 =>
                array(
                    'id' => 2,
                    'sku' => 'SINGLE',
                    'stripe_id' => 'price_1KvFquHJv0e8AgMd4gm98gtH',
                    'label' => 'Single Membership',
                    'description' => 'Single membership of the Petersham Horti',
                    'price_gbp' => 300,
                    'applies_to' => 'entrant',
                    'created_at' => '2020-07-21 11:19:06',
                    'updated_at' => '2020-07-21 11:19:06',
                    'deleted_at' => null,
                ),
        ));


    }
}
