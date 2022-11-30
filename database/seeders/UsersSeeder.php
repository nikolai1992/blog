<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 24.11.2022
 * Time: 00:56
 */
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Str;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@blog.com',
            'role_id' => Role::where('alias', 'admin')->first()->id,
            'password' => bcrypt('12345678'),
            'api_token' => Str::random(60) . time()
        ]);

        User::create([
            'name' => 'Member',
            'email' => 'member@blog.com',
            'role_id' => Role::where('alias', 'member')->first()->id,
            'password' => bcrypt('12345678'),
            'api_token' => Str::random(60) . time()
        ]);

        User::create([
            'name' => 'Free tour',
            'email' => 'free@blog.com',
            'role_id' => Role::where('alias', 'free')->first()->id,
            'password' => bcrypt('12345678'),
            'api_token' => Str::random(60) . time()
        ]);
    }
}