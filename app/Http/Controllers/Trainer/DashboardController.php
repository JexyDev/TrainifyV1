<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $trainer = auth()->user();
        
        $stats = [
            'total_workouts' => $trainer->workouts()->count(),
            'approved_workouts' => $trainer->workouts()->where('status', 'approved')->count(),
            'pending_workouts' => $trainer->workouts()->where('status', 'pending')->count(),
            'rejected_workouts' => $trainer->workouts()->where('status', 'rejected')->count(),
        ];

        $recentWorkouts = $trainer->workouts()
                                 ->with(['category', 'level'])
                                 ->latest()
                                 ->take(5)
                                 ->get();

        return view('trainer.dashboard', compact('stats', 'recentWorkouts'));
    }
}
