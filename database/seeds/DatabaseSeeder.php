<?php

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
        $this->call([UsersTableSeeder::class]);
        $this->call(CupsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(CategoryCupTableSeeder::class);
        $this->call(SectionsTableSeeder::class);
    }
}
