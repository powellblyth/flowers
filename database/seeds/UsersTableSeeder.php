<?php

use App\Category;
use App\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('entries')->truncate();
        DB::table('entrants')->truncate();
        DB::table('users')->insert([
            'firstname'            => 'Admin',
            'lastname'             => 'Admin',
            'email'                => 'admin@material.com',
            'email_verified_at'    => now(),
            'type'                 => 'admin',
            'password'             => Hash::make('secret'),
            'created_at'           => now(),
            'updated_at'           => now(),
            'auth_token'           => md5(random_int(PHP_INT_MIN, PHP_INT_MAX)),
            'password_reset_token' => ''
        ]);
        DB::table('users')->insert([
            'firstname'            => 'Toby',
            'lastname'             => 'Powell-Blyth',
            'email'                => 'toby@powellblyth.com',
            'email_verified_at'    => now(),
            'type'                 => 'admin',
            'password'             => Hash::make('moomoomoo'),
            'created_at'           => now(),
            'updated_at'           => now(),
            'auth_token'           => md5(random_int(PHP_INT_MIN, PHP_INT_MAX)),
            'password_reset_token' => ''
        ]);
        DB::table('users')->insert([
            'firstname'            => 'ES Toby',
            'lastname'             => 'Powell-Blyth',
            'email'                => 'toby.powell-blyth@elasticstage.com',
            'type'                 => 'admin',
            'email_verified_at'    => now(),
            'password'             => Hash::make('MooMooMoo1'),
            'created_at'           => now(),
            'updated_at'           => now(),
            'auth_token'           => md5(random_int(PHP_INT_MIN, PHP_INT_MAX)),
            'password_reset_token' => ''
        ]);

        $faker = Faker\Factory::create('en_GB');
        for ($userNumber = 0; $userNumber < 100; $userNumber++) {
            $user = App\User::create([
                'firstname'            => $faker->firstName,
                'lastname'             => $faker->lastName,
                'email'                => $faker->email,
                'address'              => $faker->streetAddress(),
                'addresstown'          => $faker->city(),
                'postcode'             => $faker->postcode(),
                'can_email'            => $faker->boolean(75),
                'can_retain_data'      => $faker->boolean(90),
                'type'                 => 'default',
                'created_at'           => now(),
                'updated_at'           => now(),
                'auth_token'           => md5(random_int(PHP_INT_MIN, PHP_INT_MAX)),
                'password_reset_token' => ''
            ]);


            $user->makeDefaultEntrant();
            for ($entrantNumber = 0; $entrantNumber < $faker->biasedNumberBetween(0, 5, 'Faker\Provider\Biased::linearLow'); $entrantNumber++) {
                $age  = null;
                $teamId = null;
                $isChild = $entrantNumber > 0;
                // If this is a third person it looks like a child. Only children need ages
                if ($isChild) {
                    $age  = floor(rand(1, 18));
                    $team = Team::where('min_age', '<=', $age)->where('max_age', '>=', $age)->get()->shuffle()->first();
                    if ($team instanceof Team){
                        $teamId = $team->id;
                    }
                }

                /**
                 * @var \App\Entrant $entrant
                 */
                $entrant = $user->entrants()->create([
                    'firstname'  => $faker->firstname,
                    'familyname' => $user->lastname,
                    'age'        => $age,
                    'team_id'    => $teamId,
                ]);
                // Create some historical data
                for ($year = config('app.year') - 2; $year <= config('app.year'); $year++) {

                    for ($entryNumber = 0; $entryNumber < $faker->biasedNumberBetween(0, 20, 'Faker\Provider\Biased::linearLow'); $entryNumber++) {
                        // Chooses a random set of categoreies to enter
                        $categories = Category::where('year', $year)
                            ->get()
                            ->shuffle()
                            ->take(floor(rand(0, 15)))
                            ->each(function (Category $category) use ($entrant, $year) {
                                // Creates an entry for that year
                                $entrant->entries()->create(['category_id' => $category->id, 'year' => $year]);
                            });
                    }
                }
            }

            // This ensures that we know if the 'user' was opted in or not
            //
            if ($faker->boolean(4)) {
                $user->entrants()->each(function (\App\Entrant $entrant) {
                    $entrant->anonymise()->save();
                });
                $user->anonymise()->save();
            }
        }

        Category::get()->each(function (Category $category) {
            $winners = $category->entries()->get()->shuffle()->take(4);
            foreach ($winners as $counter => $winner) {
                /**
                 * @var \App\Entry $winner
                 */
                // First prize for first entrant
                switch ($counter) {
                    case 0:
                    case 1:
                    case 2:
                        // 1 for first place
                        $winner->winningplace = $counter + 1;
                        break;
                    default:
                        $winner->winningplace = 'commended';
                }
                $winner->save();
            }
        });
    }
}
