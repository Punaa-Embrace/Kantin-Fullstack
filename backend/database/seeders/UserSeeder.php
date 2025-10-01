<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // --- Create Main Admin User ---
        // Using updateOrCreate to prevent duplicates on re-seeding.
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin JakaAja',
                'role' => 'admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // --- Create Main Tenant Manager User ---
        User::updateOrCreate(
            ['email' => 'manager@gmail.com'],
            [
                'name' => 'Pengelola Kantin 1',
                'role' => 'tenant_manager',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // --- Create Main Student User ---
        User::updateOrCreate(
            ['email' => 'student@gmail.com'],
            [
                'name' => 'Civitas Polibatam',
                'role' => 'student',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // --- Optional: Create Additional Random Users for Testing ---
        // You can uncomment these lines to populate your database with more test data.
        
        // Create 5 more Tenant Managers
        // User::factory()->count(5)->create([
        //     'role' => 'tenant_manager',
        //     'password' => Hash::make('password'),
        // ]);

        // Create 20 more Students
        // User::factory()->count(20)->create([
        //     'role' => 'student',
        //     'password' => Hash::make('password'),
        // ]);
    }
}