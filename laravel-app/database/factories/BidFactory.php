<?php

namespace Database\Factories;

use App\Models\Bid;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Bid>
 */
class BidFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => \App\Models\Project::factory(),
            'developer_id' => \App\Models\User::factory(),
            'price' => fake()->numberBetween(1, 20) * 400000,
            'duration_days' => fake()->numberBetween(7, 60),
            'proposal' => fake()->paragraph(),
            'status' => 'pending',
        ];
    }
}
