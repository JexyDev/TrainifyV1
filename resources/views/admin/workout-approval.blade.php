@extends('layouts.dashboard')

@section('title', 'Workout Approval')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Workout Approval</h1>
        <p class="text-gray-600 mt-1">Review dan approve workout dari trainer</p>
    </div>

    <!-- Pending Workouts -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">
            Pending Workouts 
            <span class="ml-2 px-3 py-1 bg-orange-100 text-orange-800 text-sm rounded-full">
                {{ $pendingWorkouts->count() }}
            </span>
        </h3>

        @forelse($pendingWorkouts as $workout)
        <div class="border border-gray-200 rounded-lg p-4 mb-4 hover:bg-gray-50 transition">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-900 text-lg">{{ $workout->title }}</h4>
                    <p class="text-sm text-gray-600 mt-1">{{ $workout->description }}</p>
                    
                    <div class="flex items-center gap-4 mt-3 text-sm text-gray-600">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ $workout->trainer->name }}
                        </span>
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                            {{ $workout->category->name }}
                        </span>
                        <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded-full">
                            {{ $workout->level->name }}
                        </span>
                        <span>{{ $workout->duration }} menit</span>
                    </div>

                    <!-- Exercises Preview -->
                    <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                        <p class="text-sm font-medium text-gray-700 mb-2">Exercises ({{ $workout->exercises->count() }}):</p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            @foreach($workout->exercises->take(3) as $exercise)
                            <li>{{ $exercise->name }} - {{ $exercise->sets }} sets x {{ $exercise->reps }} reps</li>
                            @endforeach
                            @if($workout->exercises->count() > 3)
                            <li class="text-gray-500 italic">+ {{ $workout->exercises->count() - 3 }} more...</li>
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="ml-4 flex flex-col gap-2">
                    <form action="{{ route('admin.workouts.approve', $workout) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm">
                            ✓ Approve
                        </button>
                    </form>
                    <form action="{{ route('admin.workouts.reject', $workout) }}" method="POST" onsubmit="return confirm('Yakin ingin menolak workout ini?')">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm">
                            ✗ Reject
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-8 text-gray-500">
            <svg class="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p>Tidak ada workout yang menunggu approval</p>
        </div>
        @endforelse
    </div>

    <!-- Recently Approved -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Recently Approved</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Workout</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Trainer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Level</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Duration</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($approvedWorkouts as $workout)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $workout->title }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $workout->trainer->name }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                {{ $workout->category->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800">
                                {{ $workout->level->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $workout->duration }} min</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Belum ada workout yang di-approve
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
