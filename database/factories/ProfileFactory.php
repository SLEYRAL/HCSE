<?php

namespace Database\Factories;

use App\Enum\StatusProfile;
use App\Models\Administrator;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lastname' => fake()->name(),
            'firstname' => fake()->name(),
            'image' => fake()->url(),
            'status' => fake()->randomElement(StatusProfile::toArray()),
            'user_id' => rand(1,5)
        ];
    }
}
