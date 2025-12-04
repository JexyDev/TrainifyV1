<div class="space-y-2">
    <a href="<?php echo e(route('user.dashboard')); ?>" class="flex items-center gap-3 px-4 py-3 <?php echo e(request()->routeIs('user.dashboard') ? 'bg-gradient-to-r from-blue-600 to-teal-500 text-white' : 'text-gray-700 hover:bg-gray-100'); ?> rounded-lg transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        <span>Dashboard</span>
    </a>

    <a href="<?php echo e(route('user.workouts.index')); ?>" class="flex items-center gap-3 px-4 py-3 <?php echo e(request()->routeIs('user.workouts.*') ? 'bg-gradient-to-r from-blue-600 to-teal-500 text-white' : 'text-gray-700 hover:bg-gray-100'); ?> rounded-lg transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
        </svg>
        <span>Browse Workouts</span>
    </a>

    <a href="<?php echo e(route('user.tracking')); ?>" class="flex items-center gap-3 px-4 py-3 <?php echo e(request()->routeIs('user.tracking') ? 'bg-gradient-to-r from-blue-600 to-teal-500 text-white' : 'text-gray-700 hover:bg-gray-100'); ?> rounded-lg transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
        </svg>
        <span>My Progress</span>
    </a>
</div>
<?php /**PATH C:\ProjekLaravel\TrainifyV1\resources\views/user/partials/sidebar.blade.php ENDPATH**/ ?>