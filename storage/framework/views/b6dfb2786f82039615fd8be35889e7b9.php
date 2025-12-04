<?php $__env->startSection('title', 'User Dashboard'); ?>

<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('user.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Workouts Completed</p>
                <p class="text-3xl font-bold text-gray-900"><?php echo e($stats['workouts_completed']); ?></p>
            </div>
            <div class="p-3 bg-blue-100 rounded-lg">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-orange-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Calories Burned</p>
                <p class="text-3xl font-bold text-gray-900"><?php echo e(number_format($stats['calories_burned'])); ?></p>
            </div>
            <div class="p-3 bg-orange-100 rounded-lg">
                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-teal-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Active Minutes</p>
                <p class="text-3xl font-bold text-gray-900"><?php echo e(number_format($stats['active_minutes'])); ?></p>
            </div>
            <div class="p-3 bg-teal-100 rounded-lg">
                <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="bg-white rounded-xl shadow-md p-6 mb-8">
    <h3 class="text-xl font-semibold text-gray-900 mb-4">Recent Activity</h3>
    <?php $__empty_1 = true; $__currentLoopData = $recentWorkouts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $progress): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="flex items-center gap-4 py-3 border-b border-gray-200 last:border-0">
        <div class="p-3 bg-green-100 rounded-lg">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="flex-1">
            <h4 class="font-medium text-gray-900"><?php echo e($progress->workout->title); ?></h4>
            <div class="flex items-center gap-3 text-sm text-gray-600 mt-1">
                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                    <?php echo e($progress->workout->category->name); ?>

                </span>
                <span><?php echo e($progress->completed_at->diffForHumans()); ?></span>
                <?php if($progress->calories_burned): ?>
                    <span>🔥 <?php echo e($progress->calories_burned); ?> cal</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p class="text-center text-gray-500 py-4">Belum ada aktivitas. Mulai workout sekarang!</p>
    <?php endif; ?>
</div>

<!-- Available Workouts -->
<div>
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl font-semibold text-gray-900">Recommended Workouts</h3>
        <a href="<?php echo e(route('user.workouts.index')); ?>" class="text-blue-600 hover:text-blue-800">View All →</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__currentLoopData = $availableWorkouts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workout): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('user.workouts.show', $workout)); ?>" class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition block">
            <div class="h-48 bg-gradient-to-br from-blue-500 to-teal-500 flex items-center justify-center">
                <?php if($workout->image): ?>
                    <img src="<?php echo e(asset('storage/' . $workout->image)); ?>" alt="<?php echo e($workout->title); ?>" class="w-full h-full object-cover">
                <?php else: ?>
                    <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                <?php endif; ?>
            </div>
            <div class="p-5">
                <h4 class="font-semibold text-gray-900 mb-2"><?php echo e($workout->title); ?></h4>
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                        <?php echo e($workout->category->name); ?>

                    </span>
                    <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded-full">
                        <?php echo e($workout->level->name); ?>

                    </span>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <?php echo e($workout->duration); ?> minutes
                </div>
            </div>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ProjekLaravel\TrainifyV1\resources\views/user/dashboard.blade.php ENDPATH**/ ?>