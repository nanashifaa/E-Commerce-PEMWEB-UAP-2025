<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // User Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // ubah sesuai kebutuhan
            'role' => 'admin',
        ]);

        // User Member 1
        User::create([
            'name' => 'Member One',
            'email' => 'member1@example.com',
            'password' => Hash::make('password'),
            'role' => 'member',
        ]);

        // User Member 2
        User::create([
            'name' => 'Member Two',
            'email' => 'member2@example.com',
            'password' => Hash::make('password'),
            'role' => 'member',
        ]);
    }
}
