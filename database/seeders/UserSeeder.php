<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $numberOfUsers = 50;

        // Fetch all role names from the database
        $roles = Role::pluck('name')->toArray();

        // Create users and assign a random role
        User::factory()->count($numberOfUsers)->create()->each(function ($user) use ($roles) {
            // Assign a random role
            $user->assignRole($roles[array_rand($roles)]);
        });
    }
}
