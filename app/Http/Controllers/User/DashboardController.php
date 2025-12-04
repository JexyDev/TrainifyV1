<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Workout;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'workouts_completed' => $user->workoutProgress()->count(),
            'calories_burned' => $user->workoutProgress()->sum('calories_burned'),
            'active_minutes' => $user->workoutProgress()
                                    ->join('workouts', 'user_workout_progress.workout_id', '=', 'workouts.id')
                                    ->sum('workouts.duration'),
        ];

        $recentWorkouts = $user->workoutProgress()
                              ->with('workout.category')
                              ->latest('completed_at')
                              ->take(5)
                              ->get();

        $availableWorkouts = Workout::approved()
                                   ->with(['category', 'level', 'trainer'])
                                   ->latest()
                                   ->take(6)
                                   ->get();

        return view('user.dashboard', compact('stats', 'recentWorkouts', 'availableWorkouts'));
    }
}
