<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'address' => $this->faker->streetAddress,
            'addresstown' => $this->faker->city,
            'postcode' => $this->faker->postcode,
            'can_email' => $this->faker->boolean(75),
            'can_retain_data' => $this->faker->boolean(90),
            'type' => 'default',
            'created_at' => now(),
            'updated_at' => now(),
            'password_reset_token' => '',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'auth_token' => $this->faker->md5,
        ];
    }
}
