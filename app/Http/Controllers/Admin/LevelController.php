<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $levels = Level::withCount('workouts')->get();
        $deletedLevels = Level::onlyTrashed()->withCount('workouts')->get();
        
        return view('admin.levels.index', compact('levels', 'deletedLevels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.levels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:levels'],
        ]);

        Level::create($validated);

        return redirect()->route('admin.levels.index')
                        ->with('success', 'Level berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Level $level)
    {
        return view('admin.levels.edit', compact('level'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Level $level)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:levels,name,' . $level->id],
        ]);

        $level->update($validated);

        return redirect()->route('admin.levels.index')
                        ->with('success', 'Level berhasil diupdate');
    }

    /**
     * Soft delete the specified resource from storage.
     */
    public function destroy(Level $level)
    {
        $level->delete();

        return redirect()->route('admin.levels.index')
                        ->with('success', 'Level berhasil dihapus');
    }

    /**
     * Restore soft deleted level.
     */
    public function restore($id)
    {
        $level = Level::onlyTrashed()->findOrFail($id);
        $level->restore();

        return redirect()->route('admin.levels.index')
                        ->with('success', 'Level berhasil dipulihkan');
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete($id)
    {
        $level = Level::onlyTrashed()->findOrFail($id);
        $level->forceDelete();

        return redirect()->route('admin.levels.index')
                        ->with('success', 'Level berhasil dihapus permanen');
    }
}
