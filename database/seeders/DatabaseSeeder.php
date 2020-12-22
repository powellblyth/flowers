<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CupsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(CategoryCupTableSeeder::class);
        $this->call(SectionsTableSeeder::class);
        $this->call(TeamsTableSeeder::class);
        $this->call(ShowsTableSeeder::class);
        $this->call(MembershipsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
