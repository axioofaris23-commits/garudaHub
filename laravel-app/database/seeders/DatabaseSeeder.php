<?php

namespace Database\Seeders;

use App\Models\Bid;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        $clients = User::factory(3)->create(['role' => 'client']);
        $developers = User::factory(4)->create(['role' => 'developer']);

        foreach ($clients as $client) {
            Project::factory(2)
                ->create(['client_id' => $client->id])
                ->each(function ($project) use ($developers) {
                    foreach ($developers->random(2) as $dev) {
                        Bid::factory()->create([
                            'project_id' => $project->id,
                            'developer_id' => $dev->id,
                        ]);
                    }
                });
        }
    }
}