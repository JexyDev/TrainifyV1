<?php $__env->startSection('title', 'Browse Workouts'); ?>

<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('user.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Browse Workouts</h1>
        <p class="text-gray-600 mt-1">Find the perfect workout for you</p>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <form action="<?php echo e(route('user.workouts.index')); ?>" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <select name="category" id="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">All Categories</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                            <?php echo e($category->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div>
                <label for="level" class="block text-sm font-medium text-gray-700 mb-2">Level</label>
                <select name="level" id="level" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">All Levels</option>
                    <?php $__currentLoopData = $levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($level->id); ?>" <?php echo e(request('level') == $level->id ? 'selected' : ''); ?>>
                            <?php echo e($level->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div>
                <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">Duration</label>
                <select name="duration" id="duration" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Any Duration</option>
                    <option value="short" <?php echo e(request('duration') == 'short' ? 'selected' : ''); ?>>Short (<30 min)</option>
                    <option value="medium" <?php echo e(request('duration') == 'medium' ? 'selected' : ''); ?>>Medium (30-45 min)</option>
                    <option value="long" <?php echo e(request('duration') == 'long' ? 'selected' : ''); ?>>Long (>45 min)</option>
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-gradient-to-r from-blue-600 to-teal-500 text-white rounded-lg hover:from-blue-700 hover:to-teal-600 transition">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Workouts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $workouts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workout): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <a href="<?php echo e(route('user.workouts.show', $workout)); ?>" class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition block">
            <div class="h-48 bg-gradient-to-br from-blue-500 to-teal-500 flex items-center justify-center relative">
                <?php if($workout->image): ?>
                    <img src="<?php echo e(asset('storage/' . $workout->image)); ?>" alt="<?php echo e($workout->title); ?>" class="w-full h-full object-cover">
                <?php else: ?>
                    <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                <?php endif; ?>
                <div class="absolute top-3 right-3">
                    <span class="px-3 py-1 bg-white/90 backdrop-blur-sm rounded-full text-sm font-medium">
                        <?php echo e($workout->duration); ?> min
                    </span>
                </div>
            </div>

            <div class="p-5">
                <h3 class="font-semibold text-gray-900 text-lg mb-2"><?php echo e($workout->title); ?></h3>
                <p class="text-sm text-gray-600 mb-3 line-clamp-2"><?php echo e($workout->description); ?></p>

                <div class="flex items-center gap-2 mb-3">
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                        <?php echo e($workout->category->name); ?>

                    </span>
                    <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded-full">
                        <?php echo e($workout->level->name); ?>

                    </span>
                </div>

                <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    By <?php echo e($workout->trainer->name); ?>

                </div>
            </div>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-3 text-center py-12">
            <svg class="w-20 h-20 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <p class="text-gray-500">No workouts found matching your filters</p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ProjekLaravel\TrainifyV1\resources\views/user/workouts/index.blade.php ENDPATH**/ ?>