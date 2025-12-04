@extends('layouts.dashboard')

@section('title', 'Create Workout')

@section('sidebar')
@include('trainer.partials.sidebar')
@endsection

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('trainer.workouts.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Workouts
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-2xl font-semibold text-gray-900 mb-6">Create New Workout</h2>

        <form action="{{ route('trainer.workouts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Workout Info -->
            <div class="space-y-4 mb-6">
                <h3 class="font-semibold text-gray-900">Workout Information</h3>

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="title" 
                        id="title" 
                        value="{{ old('title') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror"
                        placeholder="e.g., Full Body HIIT Blast"
                        required
                    >
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        name="description" 
                        id="description" 
                        rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                        placeholder="Describe your workout..."
                        required
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <select 
                            name="category_id" 
                            id="category_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('category_id') border-red-500 @enderror"
                            required
                        >
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="level_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Level <span class="text-red-500">*</span>
                        </label>
                        <select 
                            name="level_id" 
                            id="level_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('level_id') border-red-500 @enderror"
                            required
                        >
                            <option value="">Select Level</option>
                            @foreach($levels as $level)
                                <option value="{{ $level->id }}" {{ old('level_id') == $level->id ? 'selected' : '' }}>
                                    {{ $level->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('level_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">
                            Duration (minutes) <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            name="duration" 
                            id="duration" 
                            value="{{ old('duration') }}"
                            min="1"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('duration') border-red-500 @enderror"
                            placeholder="30"
                            required
                        >
                        @error('duration')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        Workout Image (Optional)
                    </label>
                    <input 
                        type="file" 
                        name="image" 
                        id="image" 
                        accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('image') border-red-500 @enderror"
                    >
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Max 2MB. Formats: JPG, PNG, GIF</p>
                </div>
            </div>

            <!-- Exercises -->
            <div class="mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-900">Exercises</h3>
                    <button type="button" onclick="addExercise()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                        + Add Exercise
                    </button>
                </div>

                <div id="exercises-container" class="space-y-4">
                    <!-- Exercise rows will be added here dynamically -->
                </div>
            </div>

            <!-- Submit -->
            <div class="flex gap-3">
                <button 
                    type="submit" 
                    class="px-6 py-2 bg-gradient-to-r from-blue-600 to-teal-500 text-white rounded-lg hover:from-blue-700 hover:to-teal-600 transition"
                >
                    Create Workout
                </button>
                <a 
                    href="{{ route('trainer.workouts.index') }}" 
                    class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition"
                >
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
let exerciseCount = 0;

function addExercise() {
    exerciseCount++;
    const container = document.getElementById('exercises-container');
    const exerciseHtml = `
        <div class="border border-gray-200 rounded-lg p-4 exercise-row" id="exercise-${exerciseCount}">
            <div class="flex items-center justify-between mb-3">
                <h4 class="font-medium text-gray-900">Exercise #${exerciseCount}</h4>
                <button type="button" onclick="removeExercise(${exerciseCount})" class="text-red-600 hover:text-red-800 text-sm">Remove</button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <div class="md:col-span-2">
                    <input 
                        type="text" 
                        name="exercises[${exerciseCount - 1}][name]" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                        placeholder="Exercise name"
                        required
                    >
                </div>
                <div>
                    <input 
                        type="number" 
                        name="exercises[${exerciseCount - 1}][sets]" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                        placeholder="Sets"
                        min="1"
                        required
                    >
                </div>
                <div>
                    <input 
                        type="text" 
                        name="exercises[${exerciseCount - 1}][reps]" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                        placeholder="Reps"
                        required
                    >
                </div>
                <div class="md:col-span-4">
                    <input 
                        type="number" 
                        name="exercises[${exerciseCount - 1}][rest_seconds]" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                        placeholder="Rest time (seconds)"
                        min="0"
                        required
                    >
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', exerciseHtml);
}

function removeExercise(id) {
    document.getElementById(`exercise-${id}`).remove();
}

// Add first exercise on load
document.addEventListener('DOMContentLoaded', function() {
    addExercise();
});
</script>
@endpush
@endsection
