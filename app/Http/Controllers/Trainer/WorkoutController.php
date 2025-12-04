<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Workout;
use App\Models\Category;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class WorkoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workouts = auth()->user()
                         ->workouts()
                         ->with(['category', 'level', 'exercises'])
                         ->latest()
                         ->get();

        return view('trainer.workouts.index', compact('workouts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $levels = Level::all();

        return view('trainer.workouts.create', compact('categories', 'levels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'level_id' => ['required', 'exists:levels,id'],
            'duration' => ['required', 'integer', 'min:1'],
            'image' => ['nullable', 'image', 'max:2048'],
            'exercises' => ['required', 'array', 'min:1'],
            'exercises.*.name' => ['required', 'string'],
            'exercises.*.sets' => ['required', 'integer', 'min:1'],
            'exercises.*.reps' => ['required', 'string'],
            'exercises.*.rest_seconds' => ['required', 'integer', 'min:0'],
        ]);

        // DATABASE TRANSACTION untuk memastikan data konsisten
        // Jika salah satu gagal (workout atau exercises), semua akan di-rollback
        DB::beginTransaction();
        
        try {
            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('workouts', 'public');
            }

            // Create workout
            $workout = auth()->user()->workouts()->create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'category_id' => $validated['category_id'],
                'level_id' => $validated['level_id'],
                'duration' => $validated['duration'],
                'image' => $imagePath,
                'status' => 'pending',
            ]);

            // Create exercises (relasi)
            foreach ($validated['exercises'] as $index => $exerciseData) {
                $workout->exercises()->create([
                    'name' => $exerciseData['name'],
                    'sets' => $exerciseData['sets'],
                    'reps' => $exerciseData['reps'],
                    'rest_seconds' => $exerciseData['rest_seconds'],
                    'order' => $index + 1,
                ]);
            }

            // Commit transaction jika semua berhasil
            DB::commit();

            return redirect()->route('trainer.workouts.index')
                            ->with('success', 'Workout berhasil dibuat dan menunggu approval admin');
        } catch (\Exception $e) {
            // Rollback jika ada error
            DB::rollBack();
            
            // Hapus image jika sudah terupload
            if (isset($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Terjadi kesalahan saat menyimpan workout: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Workout $workout)
    {
        // Check if workout belongs to current trainer
        if ($workout->trainer_id !== auth()->id()) {
            abort(403);
        }

        $categories = Category::all();
        $levels = Level::all();

        return view('trainer.workouts.edit', compact('workout', 'categories', 'levels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Workout $workout)
    {
        // Check if workout belongs to current trainer
        if ($workout->trainer_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'level_id' => ['required', 'exists:levels,id'],
            'duration' => ['required', 'integer', 'min:1'],
            'image' => ['nullable', 'image', 'max:2048'],
            'exercises' => ['required', 'array', 'min:1'],
            'exercises.*.name' => ['required', 'string'],
            'exercises.*.sets' => ['required', 'integer', 'min:1'],
            'exercises.*.reps' => ['required', 'string'],
            'exercises.*.rest_seconds' => ['required', 'integer', 'min:0'],
        ]);

        // DATABASE TRANSACTION untuk update
        DB::beginTransaction();
        
        try {
            $oldImage = $workout->image;

            // Handle image upload
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('workouts', 'public');
            }

            // Update workout - reset status to pending if approved
            $validated['status'] = 'pending';
            $workout->update($validated);

            // Update exercises (hapus lama, buat baru)
            $workout->exercises()->delete();
            foreach ($validated['exercises'] as $index => $exerciseData) {
                $workout->exercises()->create([
                    'name' => $exerciseData['name'],
                    'sets' => $exerciseData['sets'],
                    'reps' => $exerciseData['reps'],
                    'rest_seconds' => $exerciseData['rest_seconds'],
                    'order' => $index + 1,
                ]);
            }

            // Commit transaction
            DB::commit();
            
            // Hapus old image setelah commit berhasil
            if ($request->hasFile('image') && $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }

            return redirect()->route('trainer.workouts.index')
                            ->with('success', 'Workout berhasil diupdate dan menunggu approval admin');
        } catch (\Exception $e) {
            // Rollback jika ada error
            DB::rollBack();
            
            // Hapus new image jika sudah terupload
            if (isset($validated['image'])) {
                Storage::disk('public')->delete($validated['image']);
            }
            
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Terjadi kesalahan saat update workout: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workout $workout)
    {
        // Check if workout belongs to current trainer
        if ($workout->trainer_id !== auth()->id()) {
            abort(403);
        }

        // Delete image if exists
        if ($workout->image) {
            Storage::disk('public')->delete($workout->image);
        }

        $workout->delete();

        return redirect()->route('trainer.workouts.index')
                        ->with('success', 'Workout berhasil dihapus');
    }
}