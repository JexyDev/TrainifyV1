<?php $__env->startSection('title', 'Workout Approval'); ?>

<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
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
                <?php echo e($pendingWorkouts->count()); ?>

            </span>
        </h3>

        <?php $__empty_1 = true; $__currentLoopData = $pendingWorkouts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workout): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="border border-gray-200 rounded-lg p-4 mb-4 hover:bg-gray-50 transition">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-900 text-lg"><?php echo e($workout->title); ?></h4>
                    <p class="text-sm text-gray-600 mt-1"><?php echo e($workout->description); ?></p>
                    
                    <div class="flex items-center gap-4 mt-3 text-sm text-gray-600">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <?php echo e($workout->trainer->name); ?>

                        </span>
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                            <?php echo e($workout->category->name); ?>

                        </span>
                        <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded-full">
                            <?php echo e($workout->level->name); ?>

                        </span>
                        <span><?php echo e($workout->duration); ?> menit</span>
                    </div>

                    <!-- Exercises Preview -->
                    <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                        <p class="text-sm font-medium text-gray-700 mb-2">Exercises (<?php echo e($workout->exercises->count()); ?>):</p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <?php $__currentLoopData = $workout->exercises->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exercise): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($exercise->name); ?> - <?php echo e($exercise->sets); ?> sets x <?php echo e($exercise->reps); ?> reps</li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if($workout->exercises->count() > 3): ?>
                            <li class="text-gray-500 italic">+ <?php echo e($workout->exercises->count() - 3); ?> more...</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>

                <div class="ml-4 flex flex-col gap-2">
                    <form action="<?php echo e(route('admin.workouts.approve', $workout)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm">
                            ✓ Approve
                        </button>
                    </form>
                    <form action="<?php echo e(route('admin.workouts.reject', $workout)); ?>" method="POST" onsubmit="return confirm('Yakin ingin menolak workout ini?')">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm">
                            ✗ Reject
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="text-center py-8 text-gray-500">
            <svg class="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p>Tidak ada workout yang menunggu approval</p>
        </div>
        <?php endif; ?>
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
                    <?php $__empty_1 = true; $__currentLoopData = $approvedWorkouts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workout): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900"><?php echo e($workout->title); ?></div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($workout->trainer->name); ?></td>
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
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Belum ada workout yang di-approve
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ProjekLaravel\TrainifyV1\resources\views/admin/workout-approval.blade.php ENDPATH**/ ?>