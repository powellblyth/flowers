<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Entry;
use App\Models\Membership;
use App\Models\MembershipPurchase;
use App\Models\Show;
use App\Models\Team;
use App\Models\TeamMembership;
use App\Models\User;
use Faker\Factory;
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
            'id' => 1,
            'firstname' => 'Admin',
            'lastname' => 'Admin',
            'email' => 'admin@material.com',
            'email_verified_at' => now(),
            'type' => 'admin',
            'password' => Hash::make('secret'),
            'created_at' => now(),
            'updated_at' => now(),
            'auth_token' => md5(random_int(PHP_INT_MIN, PHP_INT_MAX)),
            'password_reset_token' => ''
        ]);
        // Makes an entrant for the user
        User::find(1)->makeDefaultEntrant();
        DB::table('users')->insert([
            'id' => 2,
            'firstname' => 'Toby',
            'lastname' => 'Powell-Blyth',
            'email' => 'toby@powellblyth.com',
            'email_verified_at' => now(),
            'type' => 'admin',
            'password' => Hash::make('moomoomoo'),
            'created_at' => now(),
            'updated_at' => now(),
            'auth_token' => md5(random_int(PHP_INT_MIN, PHP_INT_MAX)),
            'password_reset_token' => ''
        ]);
        User::find(2)->makeDefaultEntrant();

        DB::table('users')->insert([
            'id' => 3,
            'firstname' => 'ES Toby',
            'lastname' => 'Powell-Blyth',
            'email' => 'toby.powell-blyth@elasticstage.com',
            'type' => 'admin',
            'email_verified_at' => now(),
            'password' => Hash::make('MooMooMoo1'),
            'created_at' => now(),
            'updated_at' => now(),
            'auth_token' => md5(random_int(PHP_INT_MIN, PHP_INT_MAX)),
            'password_reset_token' => ''
        ]);
        User::find(3)->makeDefaultEntrant();

        $faker = Factory::create('en_GB');

        for ($userNumber = 0; $userNumber < 100; $userNumber++) {
            $user = User::create([
                'firstname' => $faker->firstName,
                'lastname' => $faker->lastName,
                'email' => $faker->email,
                'address' => $faker->streetAddress,
                'addresstown' => $faker->city,
                'postcode' => $faker->postcode,
                'can_email' => $faker->boolean(75),
                'can_retain_data' => $faker->boolean(90),
                'type' => 'default',
                'created_at' => now(),
                'updated_at' => now(),
                'auth_token' => md5(random_int(PHP_INT_MIN, PHP_INT_MAX)),
                'password_reset_token' => ''
            ]);


            $user->makeDefaultEntrant();

            $numChildren = $faker->biasedNumberBetween(0, 5, 'Faker\Provider\Biased::linearLow');

            for ($entrantNumber = 0; $entrantNumber < $numChildren; $entrantNumber++) {
                $age = floor(rand(1, 18));

                $user->entrants()->create([
                    'firstname' => $faker->firstname,
                    // In our world, every child has the same name as their parent. Makes testing easier
                    'familyname' => $user->lastname,
                    'age' => $age,
                ]);
            }

            $membershipType = null;

            // No children? Probably would choose a non family member
            if ($numChildren === 0) {
                $memberships = Membership::where('applies_to', Membership::APPLIES_TO_ENTRANT);
                $membershipType = MembershipPurchase::TYPE_INDIVIDUAL;
            } else {
                $memberships = Membership::where('applies_to', Membership::APPLIES_TO_USER);
                $membershipType = MembershipPurchase::TYPE_FAMILY;
            }
            foreach ($memberships->get() as $membership) {
                if ($faker->boolean(90)) {
                    dump($membership->id . ' - ' . $membership->applies_to . ' [' . $membershipType . ']');
                    $membershipPurchase = new MembershipPurchase();
                    $membershipPurchase->membership()->associate($membership);
                    $membershipPurchase->type = $membershipType;
                    $membershipPurchase->amount = $membership->price_gbp;
                    $membershipPurchase->user()->associate($user);
                    if ($numChildren === 0) {
                        dump('associating ' . $user->entrants()->first()->id);
                        $membershipPurchase->entrant()->associate($user->entrants()->first());
                    } else {
                        dump('THat was family');
                    }
                    $membershipPurchase->save();
                    dump(' that was purchase ID ' . $membershipPurchase->id);
                }
            }


            /////////////////////////////////////////////////////////////

            // Cache the information about sticky teams
            // Reset the array for memory reasons each new user
            $stickyTeams = [];
            // Create some historical data
            foreach (Show::all() as $show) {
                /**
                 * @var Show $show
                 */
                // reload the entrants to include the user's entrant
                foreach ($user->entrants as $entrant) {
                    // Teams are only for juniors
                    if ($entrant->age != null) {
                        if (!array_key_exists($entrant->id, $stickyTeams)) {
                            $team = Team::where('min_age', '<=', $entrant->age)
                                ->where('max_age', '>=', $entrant->age)
                                ->get()
                                ->shuffle()
                                ->first();
                        } else {
                            $team = $stickyTeams[$entrant->id];
                        }

                        // Team membership is for each show, but repeats
                        if ($team instanceof Team) {
                            $teamMembership = new TeamMembership();
                            $teamMembership->show()->associate($show);
                            $teamMembership->entrant()->associate($entrant);
                            $teamMembership->team()->associate($team);
                            $teamMembership->save();
                        }
                    }


                    // Chooses a random set of categoreies to enter
                    Category::where('show_id', $show->id)
                        ->get()
                        ->shuffle()
                        ->take(floor(rand(0, $faker->biasedNumberBetween(0, 17, 'Faker\Provider\Biased::linearLow'))))
                        ->each(function (Category $category) use ($entrant, $show, $faker) {
                            // Creates an entry for that year
                            $isLate = $faker->boolean(20);
                            $isPaid = $faker->boolean(90);
                            $paidAmount = 0;
                            if ($isPaid) {
                                $paidAmount = ($isLate) ? $category->late_price : $category->price;
                            }
                            if ($isLate) {
                                $created_date = $show->late_entry_deadline->addDay();
                            } else {
                                $created_date = $show->late_entry_deadline->subHour();
                            }
                            $entrant->entries()
                                ->create(
                                    ['category_id' => $category->id,
                                     'show_id' => $show->id,
                                     'paid' => $paidAmount,
                                     'created_at' => $created_date
                                    ]
                                );
                        });
                }
            }
            // This ensures that we know if the 'user' was opted in or not
            //
            if ($faker->boolean(4)) {
                $user->entrants()->each(function (\App\Models\Entrant $entrant) {
                    $entrant->anonymise()->save();
                });
                $user->anonymise()->save();
            }
        }
        $currentShow = Show::where('status', Show::STATUS_CURRENT)->first();

        // Choose a winner regardless of year
        // BUT NOT the current year
        Category::where('show_id', '<>', $currentShow->id)->get()->each(function (Category $category) {
            $winners = $category->entries()->get()->shuffle()->take(4);
            foreach ($winners as $counter => $winner) {
                /**
                 * @var Entry $winner
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
