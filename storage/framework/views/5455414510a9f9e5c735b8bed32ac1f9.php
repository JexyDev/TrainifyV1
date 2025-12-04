<div class="space-y-2">
    <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center gap-3 px-4 py-3 <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-blue-600 to-teal-500 text-white' : 'text-gray-700 hover:bg-gray-100'); ?> rounded-lg transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        <span>Dashboard</span>
    </a>

    <a href="<?php echo e(route('admin.workout-approval')); ?>" class="flex items-center gap-3 px-4 py-3 <?php echo e(request()->routeIs('admin.workout-approval') ? 'bg-gradient-to-r from-blue-600 to-teal-500 text-white' : 'text-gray-700 hover:bg-gray-100'); ?> rounded-lg transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span>Workout Approval</span>
    </a>

    <a href="<?php echo e(route('admin.users.index')); ?>" class="flex items-center gap-3 px-4 py-3 <?php echo e(request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-blue-600 to-teal-500 text-white' : 'text-gray-700 hover:bg-gray-100'); ?> rounded-lg transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
        </svg>
        <span>Manage Users</span>
    </a>

    <a href="<?php echo e(route('admin.categories.index')); ?>" class="flex items-center gap-3 px-4 py-3 <?php echo e(request()->routeIs('admin.categories.*') ? 'bg-gradient-to-r from-blue-600 to-teal-500 text-white' : 'text-gray-700 hover:bg-gray-100'); ?> rounded-lg transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
        </svg>
        <span>Categories</span>
    </a>

    <a href="<?php echo e(route('admin.levels.index')); ?>" class="flex items-center gap-3 px-4 py-3 <?php echo e(request()->routeIs('admin.levels.*') ? 'bg-gradient-to-r from-blue-600 to-teal-500 text-white' : 'text-gray-700 hover:bg-gray-100'); ?> rounded-lg transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
        </svg>
        <span>Levels</span>
    </a>
</div>
<?php /**PATH C:\ProjekLaravel\TrainifyV1\resources\views/admin/partials/sidebar.blade.php ENDPATH**/ ?>