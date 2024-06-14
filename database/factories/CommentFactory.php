<?php

namespace Database\Factories;

use App\Models\Administrator;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => fake()->text(500),
            'user_id' => rand(1,5),
            'profile_id' => rand(1,5)
        ];
    }
}
