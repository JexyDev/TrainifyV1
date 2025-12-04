@extends('layouts.dashboard')

@section('title', 'My Progress')

@section('sidebar')
@include('user.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">My Progress</h1>
            <p class="text-gray-600 mt-1">Track your fitness journey</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('user.tracking.export.excel') }}" class="px-4 py-2 bg-gradient-to-r from-green-600 to-teal-500 text-white rounded-lg hover:from-green-700 hover:to-teal-600 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export Excel
            </a>
            <a href="{{ route('user.tracking.export.pdf') }}" class="px-4 py-2 bg-gradient-to-r from-red-600 to-pink-500 text-white rounded-lg hover:from-red-700 hover:to-pink-600 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                Export PDF
            </a>
        </div>
    </div>

    <!-- Weekly Stats -->
    @if($weeklyStats->count() > 0)
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">This Week's Activity</h3>
        <div class="grid grid-cols-7 gap-2">
            @foreach($weeklyStats as $stat)
            <div class="text-center">
                <div class="h-32 bg-gradient-to-t from-blue-600 to-teal-500 rounded-lg flex items-end justify-center p-2" style="height: {{ ($stat->count / max($weeklyStats->pluck('count')->toArray())) * 128 }}px;">
                    <span class="text-white font-bold">{{ $stat->count }}</span>
                </div>
                <p class="text-xs text-gray-600 mt-2">{{ \Carbon\Carbon::parse($stat->date)->format('D') }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Workout History -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Workout History</h3>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Workout</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Duration</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Calories</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Notes</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($workoutHistory as $history)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $history->completed_at->format('d M Y') }}
                            <br>
                            <span class="text-xs text-gray-500">{{ $history->completed_at->format('H:i') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $history->workout->title }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                {{ $history->workout->category->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $history->workout->duration }} min
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $history->calories_burned ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $history->notes ?? '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <svg class="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <p>No workout history yet</p>
                            <a href="{{ route('user.workouts.index') }}" class="text-blue-600 hover:underline mt-2 inline-block">Start your first workout</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($workoutHistory->hasPages())
        <div class="mt-4">
            {{ $workoutHistory->links() }}
        </div>
        @endif
    </div>
</div>
@endsection