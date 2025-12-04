<?php $__env->startSection('title', 'My Workouts'); ?>

<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('trainer.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">My Workouts</h1>
            <p class="text-gray-600 mt-1">Manage your workout programs</p>
        </div>
        <a href="<?php echo e(route('trainer.workouts.create')); ?>" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-teal-500 text-white rounded-lg hover:from-blue-700 hover:to-teal-600 transition">
            + Create New Workout
        </a>
    </div>

    <!-- Workouts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $workouts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workout): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
            <!-- Image -->
            <div class="h-48 bg-gradient-to-br from-blue-500 to-teal-500 flex items-center justify-center">
                <?php if($workout->image): ?>
                    <img src="<?php echo e(asset('storage/' . $workout->image)); ?>" alt="<?php echo e($workout->title); ?>" class="w-full h-full object-cover">
                <?php else: ?>
                    <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                <?php endif; ?>
            </div>

            <!-- Content -->
            <div class="p-5">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="font-semibold text-gray-900 text-lg"><?php echo e($workout->title); ?></h3>
                    <?php if($workout->status === 'approved'): ?>
                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Approved</span>
                    <?php elseif($workout->status === 'pending'): ?>
                        <span class="px-2 py-1 text-xs rounded-full bg-orange-100 text-orange-800">Pending</span>
                    <?php else: ?>
                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Rejected</span>
                    <?php endif; ?>
                </div>

                <p class="text-sm text-gray-600 mb-4 line-clamp-2"><?php echo e($workout->description); ?></p>

                <div class="flex items-center gap-3 mb-4 text-sm text-gray-600">
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                        <?php echo e($workout->category->name); ?>

                    </span>
                    <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded-full">
                        <?php echo e($workout->level->name); ?>

                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <?php echo e($workout->duration); ?> min
                    </span>
                </div>

                <div class="text-sm text-gray-600 mb-4">
                    <strong><?php echo e($workout->exercises->count()); ?></strong> exercises
                </div>

                <div class="flex gap-2">
                    <a href="<?php echo e(route('trainer.workouts.edit', $workout)); ?>" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-center text-sm">
                        Edit
                    </a>
                    <form action="<?php echo e(route('trainer.workouts.destroy', $workout)); ?>" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus workout ini?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-3 text-center py-12">
            <svg class="w-20 h-20 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
            </svg>
            <p class="text-gray-500 mb-4">Belum ada workout</p>
            <a href="<?php echo e(route('trainer.workouts.create')); ?>" class="inline-block px-6 py-2 bg-gradient-to-r from-blue-600 to-teal-500 text-white rounded-lg hover:from-blue-700 hover:to-teal-600 transition">
                Create Your First Workout
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ProjekLaravel\TrainifyV1\resources\views/trainer/workouts/index.blade.php ENDPATH**/ ?>