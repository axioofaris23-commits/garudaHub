<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => \App\Models\User::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'category' => fake()->randomElement(['Web', 'Mobile', 'Desktop', 'Data', 'UI/UX']),
            'budget' => fake()->numberBetween(1, 20) * 500000,
            'bid_deadline' => now()->addDays(fake()->numberBetween(3, 30)),
            'status' => 'open',
        ];
    }
}
