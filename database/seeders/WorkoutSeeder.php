<?php

namespace Database\Seeders;

use App\Models\Workout;
use App\Models\Exercise;
use App\Models\User;
use App\Models\Category;
use App\Models\Level;
use Illuminate\Database\Seeder;

class WorkoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trainer = User::where('email', 'trainer@trainify.com')->first();
        
        // Workout 1: Full Body Strength Training (Approved)
        $workout1 = Workout::create([
            'trainer_id' => $trainer->id,
            'category_id' => Category::where('slug', 'strength')->first()->id,
            'level_id' => Level::where('slug', 'intermediate')->first()->id,
            'title' => 'Full Body Strength Training',
            'description' => 'Build muscle and increase strength with compound movements',
            'duration' => 45,
            'status' => 'approved',
        ]);

        // Exercises for Workout 1
        Exercise::create([
            'workout_id' => $workout1->id,
            'name' => 'Squats',
            'sets' => 4,
            'reps' => '8-10',
            'rest_seconds' => 90,
            'order' => 1,
        ]);

        Exercise::create([
            'workout_id' => $workout1->id,
            'name' => 'Bench Press',
            'sets' => 4,
            'reps' => '8-10',
            'rest_seconds' => 90,
            'order' => 2,
        ]);

        Exercise::create([
            'workout_id' => $workout1->id,
            'name' => 'Deadlifts',
            'sets' => 3,
            'reps' => '6-8',
            'rest_seconds' => 120,
            'order' => 3,
        ]);

        Exercise::create([
            'workout_id' => $workout1->id,
            'name' => 'Pull-ups',
            'sets' => 3,
            'reps' => '8-12',
            'rest_seconds' => 90,
            'order' => 4,
        ]);

        // Workout 2: HIIT Cardio Blast (Pending)
        $workout2 = Workout::create([
            'trainer_id' => $trainer->id,
            'category_id' => Category::where('slug', 'cardio')->first()->id,
            'level_id' => Level::where('slug', 'advanced')->first()->id,
            'title' => 'HIIT Cardio Blast',
            'description' => 'High-intensity interval training for maximum calorie burn',
            'duration' => 30,
            'status' => 'pending',
        ]);

        Exercise::create([
            'workout_id' => $workout2->id,
            'name' => 'Burpees',
            'sets' => 4,
            'reps' => '15',
            'rest_seconds' => 30,
            'order' => 1,
        ]);

        Exercise::create([
            'workout_id' => $workout2->id,
            'name' => 'Mountain Climbers',
            'sets' => 4,
            'reps' => '20',
            'rest_seconds' => 30,
            'order' => 2,
        ]);

        // Workout 3: Yoga Flow for Flexibility (Approved)
        $workout3 = Workout::create([
            'trainer_id' => $trainer->id,
            'category_id' => Category::where('slug', 'yoga')->first()->id,
            'level_id' => Level::where('slug', 'beginner')->first()->id,
            'title' => 'Yoga Flow for Flexibility',
            'description' => 'Improve flexibility and reduce stress with flowing movements',
            'duration' => 60,
            'status' => 'approved',
        ]);

        Exercise::create([
            'workout_id' => $workout3->id,
            'name' => 'Sun Salutation',
            'sets' => 5,
            'reps' => '1',
            'rest_seconds' => 10,
            'order' => 1,
        ]);

        Exercise::create([
            'workout_id' => $workout3->id,
            'name' => 'Warrior Pose',
            'sets' => 3,
            'reps' => '30 sec hold',
            'rest_seconds' => 15,
            'order' => 2,
        ]);

        // Workout 4: Core & Abs Sculpting (Approved)
        $workout4 = Workout::create([
            'trainer_id' => $trainer->id,
            'category_id' => Category::where('slug', 'strength')->first()->id,
            'level_id' => Level::where('slug', 'intermediate')->first()->id,
            'title' => 'Core & Abs Sculpting',
            'description' => 'Target your core with effective ab exercises',
            'duration' => 25,
            'status' => 'approved',
        ]);

        Exercise::create([
            'workout_id' => $workout4->id,
            'name' => 'Plank',
            'sets' => 4,
            'reps' => '60 sec',
            'rest_seconds' => 30,
            'order' => 1,
        ]);

        Exercise::create([
            'workout_id' => $workout4->id,
            'name' => 'Russian Twists',
            'sets' => 3,
            'reps' => '20',
            'rest_seconds' => 30,
            'order' => 2,
        ]);
    }
}
