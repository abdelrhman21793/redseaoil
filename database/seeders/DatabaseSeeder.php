<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a default superadmin user
        User::firstOrCreate(
            ['email' => 'admin@redseaoil.com'],
            [
                'name' => 'Super Admin',
                'email' => 'admin@redseaoil.com',
                'password' => Hash::make('password'),
                'type' => 'SUPER_ADMIN',
                'email_verified_at' => now(),
            ]
        );

        // Create a demo admin user
        User::firstOrCreate(
            ['email' => 'demo@redseaoil.com'],
            [
                'name' => 'Demo Admin',
                'email' => 'demo@redseaoil.com',
                'password' => Hash::make('password'),
                'type' => 'ADMIN',
                'email_verified_at' => now(),
            ]
        );
    }
}
