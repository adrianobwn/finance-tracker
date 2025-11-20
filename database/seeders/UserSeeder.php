<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User only
        User::create([
            'name' => 'Admin',
            'email' => 'admin@finance.com',
            'password' => Hash::make('password'),
            'role' => UserRole::ADMIN,
            'email_verified_at' => now(),
            'currency' => 'IDR',
        ]);
    }
}
