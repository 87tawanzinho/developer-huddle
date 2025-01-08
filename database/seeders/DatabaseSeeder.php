<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Task;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(class: PlanSeeder::class);

        User::factory(10)->withAddress()->withSubscription()->create();
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin'
            ]);

        $user->subscription()->create([
            'plan_id' => 3,
            'status' => 'active',
            'gateway_id' => '123',
        ]);

        $projects = Project::factory(5)->create();

        foreach ($projects as $project) {
            $project->users()->attach($user, ['role' => 'owner']);
            Task::factory(5)->create([
                'project_id' => $project->id,
                'responsible_id' => $user->id
            ]);
        }
    }
}
