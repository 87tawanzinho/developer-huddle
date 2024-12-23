<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(class: UserAdminSeed::class);
        
          // Cria 10 usuários
          User::factory(10)->create()->each(function ($user) {
            // Cria 3 projetos para cada usuário
            $projects = Project::factory(3)->create();

            // Associa os projetos ao usuário na tabela pivot
            $user->projects()->attach($projects->pluck('id')->toArray());
        });
    }
}
