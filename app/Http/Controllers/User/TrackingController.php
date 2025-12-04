<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Exports\UserProgressExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class TrackingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get workout history
        $workoutHistory = $user->workoutProgress()
                             ->with('workout.category')
                             ->latest('completed_at')
                             ->paginate(10);

        // Weekly stats (last 7 days)
        $weeklyStats = $user->workoutProgress()
                          ->where('completed_at', '>=', now()->subDays(7))
                          ->selectRaw('DATE(completed_at) as date, COUNT(*) as count, SUM(calories_burned) as calories')
                          ->groupBy('date')
                          ->orderBy('date')
                          ->get();

        return view('user.tracking', compact('workoutHistory', 'weeklyStats'));
    }

    public function exportExcel()
    {
        return Excel::download(new UserProgressExport(auth()->id()), 'my-workout-progress.xlsx');
    }

    public function exportPdf()
    {
        $user = auth()->user();
        
        // Get workout history (all data for PDF)
        $workoutHistory = $user->workoutProgress()
                             ->with(['workout.category', 'workout.level'])
                             ->latest('completed_at')
                             ->get();

        // Calculate summary stats
        $totalWorkouts = $workoutHistory->count();
        $totalCalories = $workoutHistory->sum('calories_burned');
        $totalDuration = $workoutHistory->sum(function($progress) {
            return $progress->workout->duration ?? 0;
        });

        $pdf = Pdf::loadView('user.tracking-pdf', compact(
            'user',
            'workoutHistory',
            'totalWorkouts',
            'totalCalories',
            'totalDuration'
        ));

        return $pdf->download('my-workout-progress.pdf');
    }
}