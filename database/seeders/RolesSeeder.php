<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        Role::create([
            'name' => 'Admin',
            'alias' => 'admin',
        ]);

        Role::create([
            'name' => 'Member',
            'alias' => 'member',
        ]);

        Role::create([
            'name' => 'Free',
            'alias' => 'free',
        ]);
    }
}
