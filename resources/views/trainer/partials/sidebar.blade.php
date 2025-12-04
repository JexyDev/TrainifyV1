<div class="space-y-2">
    <a href="{{ route('trainer.dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('trainer.dashboard') ? 'bg-gradient-to-r from-blue-600 to-teal-500 text-white' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        <span>Dashboard</span>
    </a>

    <a href="{{ route('trainer.workouts.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('trainer.workouts.*') ? 'bg-gradient-to-r from-blue-600 to-teal-500 text-white' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
        </svg>
        <span>My Workouts</span>
    </a>

    <a href="{{ route('trainer.profile.edit') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('trainer.profile.*') ? 'bg-gradient-to-r from-blue-600 to-teal-500 text-white' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
        </svg>
        <span>Profile</span>
    </a>
</div>
