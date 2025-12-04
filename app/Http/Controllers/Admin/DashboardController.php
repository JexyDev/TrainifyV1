<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Workout;
use App\Models\Category;
use App\Models\UserWorkoutProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_trainers' => User::where('role', 'trainer')->count(),
            'total_workouts' => Workout::count(),
            'pending_trainers' => User::where('role', 'trainer')
                                      ->whereDate('created_at', '>=', now()->subDays(7))
                                      ->count(),
            'pending_workouts' => Workout::where('status', 'pending')->count(),
        ];

        $workoutsByCategoryTable = Workout::with(['trainer', 'category'])
                                         ->latest()
                                         ->take(10)
                                         ->get()
                                         ->groupBy('category.name')
                                         ->take(1); // Limit to 1 category

        // Data untuk Chart.js - User Growth (30 hari terakhir)
        $userGrowthData = User::where('role', 'user')
                            ->where('created_at', '>=', now()->subDays(30))
                            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
                            ->groupBy('date')
                            ->orderBy('date')
                            ->get();

        // Data untuk Chart.js - Workout by Category
        $workoutsByCategory = Workout::select('categories.name as category', DB::raw('COUNT(*) as count'))
                                    ->join('categories', 'workouts.category_id', '=', 'categories.id')
                                    ->groupBy('categories.id', 'categories.name')
                                    ->get();

        // Data untuk Chart.js - Workout Completions (7 hari terakhir)
        $workoutCompletions = UserWorkoutProgress::where('completed_at', '>=', now()->subDays(7))
                                    ->select(DB::raw('DATE(completed_at) as date'), DB::raw('COUNT(*) as count'))
                                    ->groupBy('date')
                                    ->orderBy('date')
                                    ->get();

        return view('admin.dashboard', compact(
            'stats',
            'workoutsByCategoryTable',
            'userGrowthData',
            'workoutsByCategory',
            'workoutCompletions'
        ));
    }
}