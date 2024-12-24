<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserAdminSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         User::create([
            "name" => "Admin",
            "email" => "admin@admin",
            "password" => bcrypt("12345678"),
            ]);

            User::create([
                "name" => "Marina",
                "email" => "marina@marina",
                "password" => bcrypt("12345678"),
                ]);

          
    }
}
