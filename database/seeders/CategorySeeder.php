<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Strength', 'slug' => 'strength'],
            ['name' => 'Cardio', 'slug' => 'cardio'],
            ['name' => 'Yoga', 'slug' => 'yoga'],
            ['name' => 'HIIT', 'slug' => 'hiit'],
            ['name' => 'General', 'slug' => 'general'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
