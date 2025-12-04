<?php $__env->startSection('title', 'Trainer Dashboard'); ?>

<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('trainer.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Total Workouts</p>
                <p class="text-3xl font-bold text-gray-900"><?php echo e($stats['total_workouts']); ?></p>
            </div>
            <div class="p-3 bg-blue-100 rounded-lg">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Approved</p>
                <p class="text-3xl font-bold text-gray-900"><?php echo e($stats['approved_workouts']); ?></p>
            </div>
            <div class="p-3 bg-green-100 rounded-lg">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-orange-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Pending</p>
                <p class="text-3xl font-bold text-gray-900"><?php echo e($stats['pending_workouts']); ?></p>
            </div>
            <div class="p-3 bg-orange-100 rounded-lg">
                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-red-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Rejected</p>
                <p class="text-3xl font-bold text-gray-900"><?php echo e($stats['rejected_workouts']); ?></p>
            </div>
            <div class="p-3 bg-red-100 rounded-lg">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-gradient-to-r from-blue-600 to-teal-500 rounded-xl shadow-lg p-6 mb-8 text-white">
    <h3 class="text-xl font-semibold mb-4">Quick Actions</h3>
    <div class="flex gap-4">
        <a href="<?php echo e(route('trainer.workouts.create')); ?>" class="px-6 py-3 bg-white text-blue-600 rounded-lg hover:bg-gray-100 transition font-semibold">
            + Create New Workout
        </a>
        <a href="<?php echo e(route('trainer.workouts.index')); ?>" class="px-6 py-3 bg-white/20 hover:bg-white/30 rounded-lg transition">
            View All Workouts
        </a>
    </div>
</div>

<!-- Recent Workouts -->
<div class="bg-white rounded-xl shadow-md p-6">
    <h3 class="text-xl font-semibold text-gray-900 mb-4">Recent Workouts</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Workout</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Level</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Duration</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $recentWorkouts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workout): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900"><?php echo e($workout->title); ?></div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                            <?php echo e($workout->category->name); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800">
                            <?php echo e($workout->level->name); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($workout->duration); ?> min</td>
                    <td class="px-6 py-4">
                        <?php if($workout->status === 'approved'): ?>
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Approved</span>
                        <?php elseif($workout->status === 'pending'): ?>
                            <span class="px-2 py-1 text-xs rounded-full bg-orange-100 text-orange-800">Pending</span>
                        <?php else: ?>
                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Rejected</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        Belum ada workout. <a href="<?php echo e(route('trainer.workouts.create')); ?>" class="text-blue-600 hover:underline">Buat workout pertama Anda</a>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ProjekLaravel\TrainifyV1\resources\views/trainer/dashboard.blade.php ENDPATH**/ ?>