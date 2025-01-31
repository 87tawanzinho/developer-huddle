<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        Plan::create([
            'name' => 'Free',
            'type' => 'free',
            'description' => 'Plano gratuito, para pessoas que só querem participar dos projetos',
            'icon' => [
                'class' => 'material-symbols:monitor-outline-rounded',
                'color' => '#6B7280',
            ],
            'count_projects' => 0,
            'count_users_project' => 0,
            'count_admin_project' => 0,
            'price' => 0.00,
        ]);

        Plan::create([
            'name' => 'Básico',
            'type' => 'basic',
            'description' => 'Plano básico, para pessoas que querem criar projetos',
            'icon' => [
                'class' => 'mdi:account-circle-outline',
                'color' => '#0082F6',
            ],
            'count_projects' => 3,
            'count_users_project' => 5,
            'count_admin_project' => 1,
            'price' => 29.99,
        ]);

        Plan::create([
            'name' => 'Premium',
            'type' => 'premium',
            'description' => 'Plano Premium, para pessoas que querem criar mais projetos',
            'icon' => [
                'class'=> 'mdi:crown-outline',
                'color' => '#EAB308',
            ],
            'count_projects' => 10,
            'count_users_project' => 10,
            'count_admin_project' => 3,
            'price' => 59.99,
        ]);

        Plan::create([
            'name' => 'Enterprise',
            'type' => 'enterprise',
            'description' => 'Plano enterprise, para empresas que querem criar muitos projetos',
            'icon' => [
                'class' => 'mdi:rocket-outline',
                'color' => '#A855F7',
            ],
            'count_projects' => 30,
            'count_users_project' => 30,
            'count_admin_project' => 10,
            'price' => 99.99,
        ]);
    }
}
