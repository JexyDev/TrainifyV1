<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Trainify',
            'email' => 'admin@trainify.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Trainer
        User::create([
            'name' => 'Mike Johnson',
            'email' => 'trainer@trainify.com',
            'password' => Hash::make('password'),
            'role' => 'trainer',
            'specialization' => 'Strength Training, HIIT, Nutrition',
            'certifications' => 'NASM-CPT, ISSA Nutrition',
            'bio' => 'Certified personal trainer with 8+ years of experience in strength training and nutrition coaching.',
        ]);

        // Regular User
        User::create([
            'name' => 'John Doe',
            'email' => 'user@trainify.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'height' => 175,
            'weight' => 70,
            'age' => 28,
            'bio' => 'Fitness enthusiast passionate about health and wellness.',
        ]);

        // Additional Trainers (Pending Approval Example)
        User::create([
            'name' => 'Sarah Davis',
            'email' => 'sarah.davis@example.com',
            'password' => Hash::make('password'),
            'role' => 'trainer',
            'specialization' => 'Yoga, Pilates',
            'certifications' => 'RYT-200, NASM',
            'bio' => 'Yoga instructor specializing in Hatha and Vinyasa styles.',
        ]);

        // Additional Users
        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'height' => 165,
            'weight' => 60,
            'age' => 25,
        ]);
    }
}
