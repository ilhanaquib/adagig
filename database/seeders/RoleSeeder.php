<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Organisers']);
        Role::create(['name' => 'Band/Artist']);
        Role::create(['name' => 'Writers']);
        Role::create(['name' => 'Creatives']);
    }
}
