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
                    'sku' => 'FAMILY_2017',
                    'label' => 'Family Membership 2017',
                    'description' => '2017 Family Membership',
                    'price_gbp' => 500,
                    'applies_to' => 'user',
                    'purchasable_from' => '2017-05-01 00:00:00',
                    'purchasable_to' => '2018-04-30 23:59:59',
                    'valid_from' => '2017-06-01 00:00:00',
                    'valid_to' => '2018-05-31 23:59:59',
                    'created_at' => '2020-07-21 11:19:06',
                    'updated_at' => '2020-07-21 11:19:06',
                    'deleted_at' => null,
                ),
            1 =>
                array(
                    'id' => 2,
                    'sku' => 'SINGLE_2017',
                    'label' => 'Single Membership 2017',
                    'description' => '2017 Single Membership',
                    'price_gbp' => 300,
                    'applies_to' => 'entrant',
                    'purchasable_from' => '2017-05-01 00:00:00',
                    'purchasable_to' => '2018-04-30 23:59:59',
                    'valid_from' => '2017-06-01 00:00:00',
                    'valid_to' => '2018-05-31 23:59:59',
                    'created_at' => '2020-07-21 11:19:06',
                    'updated_at' => '2020-07-21 11:19:06',
                    'deleted_at' => null,
                ),
            2 =>
                array(
                    'id' => 3,
                    'sku' => 'FAMILY_2018',
                    'label' => 'Family Membership 2018',
                    'description' => '2018 Family Membership',
                    'price_gbp' => 500,
                    'applies_to' => 'user',
                    'purchasable_from' => '2018-05-01 00:00:00',
                    'purchasable_to' => '2019-04-30 23:59:59',
                    'valid_from' => '2018-06-01 00:00:00',
                    'valid_to' => '2019-05-31 23:59:59',
                    'created_at' => '2020-07-21 11:19:06',
                    'updated_at' => '2020-07-21 11:19:06',
                    'deleted_at' => null,
                ),
            3 =>
                array(
                    'id' => 4,
                    'sku' => 'SINGLE_2018',
                    'label' => 'Single Membership 2018',
                    'description' => '2018 Single Membership',
                    'price_gbp' => 300,
                    'applies_to' => 'entrant',
                    'purchasable_from' => '2018-05-01 00:00:00',
                    'purchasable_to' => '2019-04-30 23:59:59',
                    'valid_from' => '2018-06-01 00:00:00',
                    'valid_to' => '2019-05-31 23:59:59',
                    'created_at' => '2020-07-21 11:19:06',
                    'updated_at' => '2020-07-21 11:19:06',
                    'deleted_at' => null,
                ),
            4 =>
                array(
                    'id' => 5,
                    'sku' => 'FAMILY_2019',
                    'label' => 'Family Membership 2019',
                    'description' => '2019 Family Membership',
                    'price_gbp' => 500,
                    'applies_to' => 'user',
                    'purchasable_from' => '2019-05-01 00:00:00',
                    'purchasable_to' => '2020-04-30 23:59:59',
                    'valid_from' => '2019-06-01 00:00:00',
                    'valid_to' => '2020-05-31 23:59:59',
                    'created_at' => '2020-07-21 11:19:06',
                    'updated_at' => '2020-07-21 11:19:06',
                    'deleted_at' => null,
                ),
            5 =>
                array(
                    'id' => 6,
                    'sku' => 'SINGLE_2019',
                    'label' => 'Single Membership 2019',
                    'description' => '2019 Single Membership',
                    'price_gbp' => 300,
                    'applies_to' => 'entrant',
                    'purchasable_from' => '2019-05-01 00:00:00',
                    'purchasable_to' => '2020-04-30 23:59:59',
                    'valid_from' => '2019-06-01 00:00:00',
                    'valid_to' => '2020-05-31 23:59:59',
                    'created_at' => '2020-07-21 11:19:06',
                    'updated_at' => '2020-07-21 11:19:06',
                    'deleted_at' => null,
                ),
            6 =>
                array(
                    'id' => 7,
                    'sku' => 'FAMILY_2020',
                    'label' => 'Family Membership 2020',
                    'description' => '2020 Family Membership',
                    'price_gbp' => 500,
                    'applies_to' => 'user',
                    'purchasable_from' => '2020-05-01 00:00:00',
                    'purchasable_to' => '2021-04-30 23:59:59',
                    'valid_from' => '2020-06-01 00:00:00',
                    'valid_to' => '2021-05-31 23:59:59',
                    'created_at' => '2020-07-21 11:19:06',
                    'updated_at' => '2020-07-21 11:19:06',
                    'deleted_at' => null,
                ),
            7 =>
                array(
                    'id' => 8,
                    'sku' => 'SINGLE_2020',
                    'label' => 'Single Membership 2020',
                    'description' => '2020 Single Membership',
                    'price_gbp' => 300,
                    'applies_to' => 'entrant',
                    'purchasable_from' => '2020-05-01 00:00:00',
                    'purchasable_to' => '2021-04-30 23:59:59',
                    'valid_from' => '2020-06-01 00:00:00',
                    'valid_to' => '2021-05-31 23:59:59',
                    'created_at' => '2020-07-21 11:19:06',
                    'updated_at' => '2020-07-21 11:19:06',
                    'deleted_at' => null,
                ),
        ));


    }
}
