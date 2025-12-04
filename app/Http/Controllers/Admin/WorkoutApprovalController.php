<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Workout;
use Illuminate\Http\Request;

class WorkoutApprovalController extends Controller
{
    public function index()
    {
        $pendingWorkouts = Workout::with(['trainer', 'category', 'level', 'exercises'])
                                  ->where('status', 'pending')
                                  ->latest()
                                  ->get();

        $approvedWorkouts = Workout::with(['trainer', 'category', 'level'])
                                   ->where('status', 'approved')
                                   ->latest()
                                   ->take(10)
                                   ->get();

        return view('admin.workout-approval', compact('pendingWorkouts', 'approvedWorkouts'));
    }

    public function approve(Workout $workout)
    {
        $workout->update(['status' => 'approved']);

        return redirect()->route('admin.workout-approval')
                        ->with('success', 'Workout berhasil di-approve');
    }

    public function reject(Workout $workout)
    {
        $workout->update(['status' => 'rejected']);

        return redirect()->route('admin.workout-approval')
                        ->with('success', 'Workout berhasil ditolak');
    }
}
