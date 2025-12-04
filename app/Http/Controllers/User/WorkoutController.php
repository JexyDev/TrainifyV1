<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Workout;
use App\Models\Category;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkoutController extends Controller
{
    public function index(Request $request)
    {
        $query = Workout::approved()
                       ->with(['category', 'level', 'trainer', 'exercises']);

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by level
        if ($request->filled('level')) {
            $query->where('level_id', $request->level);
        }

        // Filter by duration
        if ($request->filled('duration')) {
            switch ($request->duration) {
                case 'short':
                    $query->where('duration', '<', 30);
                    break;
                case 'medium':
                    $query->whereBetween('duration', [30, 45]);
                    break;
                case 'long':
                    $query->where('duration', '>', 45);
                    break;
            }
        }

        $workouts = $query->latest()->get();
        $categories = Category::all();
        $levels = Level::all();

        return view('user.workouts.index', compact('workouts', 'categories', 'levels'));
    }

    public function show(Workout $workout)
    {
        $workout->load(['category', 'level', 'trainer', 'exercises']);
        
        // Check if user has completed this workout
        $userProgress = auth()->user()
                            ->workoutProgress()
                            ->where('workout_id', $workout->id)
                            ->latest()
                            ->first();

        return view('user.workouts.show', compact('workout', 'userProgress'));
    }

    public function complete(Request $request, Workout $workout)
    {
        $validated = $request->validate([
            'calories_burned' => ['nullable', 'integer', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);

        // DATABASE TRANSACTION untuk complete workout
        // Pastikan data progress tersimpan dengan benar
        DB::beginTransaction();
        
        try {
            // Create workout progress
            auth()->user()->workoutProgress()->create([
                'workout_id' => $workout->id,
                'completed_at' => now(),
                'calories_burned' => $validated['calories_burned'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            // Bisa ditambahkan logic lain seperti:
            // - Update user stats
            // - Give achievement/badge
            // - Send notification to trainer
            
            // Commit transaction
            DB::commit();

            return redirect()->route('user.workouts.show', $workout)
                            ->with('success', 'Workout completed! Great job! 💪');
        } catch (\Exception $e) {
            // Rollback jika error
            DB::rollBack();
            
            return redirect()->back()
                            ->with('error', 'Terjadi kesalahan saat menyimpan progress: ' . $e->getMessage());
        }
    }
}