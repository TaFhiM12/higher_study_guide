<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin Puspita',
            'email' => 'admin@example.com',
            'role' => User::ROLE_ADMIN,
            'password' => bcrypt('password'),
        ]);

        User::create([
            'name' => 'Sunrise Agency',
            'email' => 'agency@example.com',
            'role' => User::ROLE_AGENCY,
            'password' => bcrypt('password'),
        ]);

        User::create([
            'name' => 'Student Chatur',
            'email' => 'student@example.com',
            'role' => User::ROLE_STUDENT,
            'password' => bcrypt('password'),
        ]);
    }
}

