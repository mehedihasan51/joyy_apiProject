<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory {
    protected $model = User::class;

    public function definition(): array {
        return [
            'first_name'     => $this->faker->firstName,
            'last_name'      => $this->faker->lastName,
            'email'          => $this->faker->unique()->safeEmail,
            'password'       => bcrypt('12345678'),
            'remember_token' => Str::random(10),
        ];
    }
}
