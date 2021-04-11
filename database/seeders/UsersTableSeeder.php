<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Entrant;
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

        $faker = Factory::create('en_GB');

        $user = User::factory()->create([
            'id' => 1,
            'firstname' => 'Admin',
            'lastname' => 'Admin',
            'email' => 'admin@material.com',
            'email_verified_at' => now(),
            'type' => 'admin',
            'password' => Hash::make('secret'),
        ]);
        // Makes an entrant for the user
        $user->makeDefaultEntrant();

        $user = User::factory()->create([
            'firstname' => 'Toby',
            'lastname' => 'Powell-Blyth',
            'email' => 'toby@powellblyth.com',
            'email_verified_at' => now(),
            'type' => 'admin',
            'password' => Hash::make('moomoomoo'),
        ]);
        $user->makeDefaultEntrant();

        $user = User::factory()->create([
            'firstname' => 'ES Toby',
            'lastname' => 'Powell-Blyth',
            'email' => 'toby.powell-blyth@elasticstage.com',
            'type' => 'admin',
            'email_verified_at' => now(),
            'password' => Hash::make('MooMooMoo1'),
        ]);
        $user->makeDefaultEntrant();

        for ($userNumber = 0; $userNumber < 100; $userNumber++) {
            /**
             * @var User $user
             */
            $user = User::factory()->create();

            $user->makeDefaultEntrant();

            $numChildren = $faker->biasedNumberBetween(0, 5, 'Faker\Provider\Biased::linearLow');

            for ($entrantNumber = 0; $entrantNumber < $numChildren; $entrantNumber++) {
                Entrant::factory()->create([
                    // In our world, every child has the same name as their parent. Makes testing easier
                    'familyname' => $user->lastname,
                    'user_id' => $user->id,
                ]);
            }

            // No children? Probably would choose a non family member
            if ($numChildren === 0) {
                $memberships = Membership::where('applies_to', Membership::APPLIES_TO_ENTRANT);
                $membershipType = MembershipPurchase::TYPE_INDIVIDUAL;
            } else {
                $memberships = Membership::where('applies_to', Membership::APPLIES_TO_USER);
                $membershipType = MembershipPurchase::TYPE_FAMILY;
            }
            foreach ($memberships->get() as $membership) {
                /**
                 * @var Membership $membership
                 */
                if ($faker->boolean(80)) {
                    dump($membership->id . ' - ' . $membership->applies_to . ' [' . $membershipType . ']');
                    $membershipPurchase = new MembershipPurchase();
                    $membershipPurchase->membership()->associate($membership);
                    $membershipPurchase->type = $membershipType;
                    $membershipPurchase->amount = $membership->price_gbp;
                    $membershipPurchase->start_date = $membership->valid_from;
                    $membershipPurchase->end_date = $membership->valid_to;
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
                    /**
                     * @var Entrant $entrant
                     */
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
                        // If you are 1 there is no team
                        if ($team instanceof Team) {
                            $entrant->teams()->save($team, ['show_id' => $show->id]);
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
                $user->entrants()->each(function (Entrant $entrant) {
                    $entrant->anonymise()->save();
                });
                $user->anonymise()->save();
            }
        }
        /**
         * @var Show $currentShow
         */
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
