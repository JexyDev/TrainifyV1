<?php $__env->startSection('title', $workout->title); ?>

<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('user.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl">
    <div class="mb-6">
        <a href="<?php echo e(route('user.workouts.index')); ?>" class="text-blue-600 hover:text-blue-800 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Workouts
        </a>
    </div>

    <!-- Workout Header -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
        <?php if($workout->image): ?>
        <div class="h-64 w-full">
            <img src="<?php echo e(asset('storage/' . $workout->image)); ?>" alt="<?php echo e($workout->title); ?>" class="w-full h-full object-cover">
        </div>
        <?php else: ?>
        <div class="h-64 bg-gradient-to-br from-blue-500 to-teal-500 flex items-center justify-center">
            <svg class="w-32 h-32 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
            </svg>
        </div>
        <?php endif; ?>

        <div class="p-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-3"><?php echo e($workout->title); ?></h1>
            
            <div class="flex items-center gap-4 mb-4">
                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full"><?php echo e($workout->category->name); ?></span>
                <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full"><?php echo e($workout->level->name); ?></span>
                <span class="flex items-center gap-1 text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <?php echo e($workout->duration); ?> minutes
                </span>
                <span class="flex items-center gap-1 text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <?php echo e($workout->trainer->name); ?>

                </span>
            </div>

            <p class="text-gray-700 mb-6"><?php echo e($workout->description); ?></p>

            <?php if($userProgress): ?>
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                <p class="text-green-800 font-medium">✓ You completed this workout on <?php echo e($userProgress->completed_at->format('d M Y')); ?></p>
                <?php if($userProgress->calories_burned): ?>
                    <p class="text-sm text-green-700 mt-1">Calories burned: <?php echo e($userProgress->calories_burned); ?></p>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <button 
                onclick="document.getElementById('complete-modal').classList.remove('hidden')"
                class="px-8 py-3 bg-gradient-to-r from-blue-600 to-teal-500 text-white rounded-lg hover:from-blue-700 hover:to-teal-600 transition font-semibold"
            >
                <?php echo e($userProgress ? 'Complete Again' : 'Start Workout'); ?>

            </button>
        </div>
    </div>

    <!-- Exercises -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">Exercises (<?php echo e($workout->exercises->count()); ?>)</h2>
        
        <div class="space-y-4">
            <?php $__currentLoopData = $workout->exercises; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exercise): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-900 text-lg mb-2"><?php echo e($loop->iteration); ?>. <?php echo e($exercise->name); ?></h3>
                        <div class="flex items-center gap-4 text-sm text-gray-600">
                            <span class="flex items-center gap-1">
                                <strong><?php echo e($exercise->sets); ?></strong> sets
                            </span>
                            <span class="flex items-center gap-1">
                                <strong><?php echo e($exercise->reps); ?></strong> reps
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <?php echo e($exercise->rest_seconds); ?>s rest
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>

<!-- Complete Workout Modal -->
<div id="complete-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Complete Workout</h3>
        
        <form action="<?php echo e(route('user.workouts.complete', $workout)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            
            <div class="mb-4">
                <label for="calories_burned" class="block text-sm font-medium text-gray-700 mb-2">
                    Calories Burned (Optional)
                </label>
                <input 
                    type="number" 
                    name="calories_burned" 
                    id="calories_burned" 
                    min="0"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                    placeholder="e.g., 350"
                >
            </div>

            <div class="mb-4">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                    Notes (Optional)
                </label>
                <textarea 
                    name="notes" 
                    id="notes" 
                    rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                    placeholder="How did it go?"
                ></textarea>
            </div>

            <div class="flex gap-3">
                <button 
                    type="submit" 
                    class="flex-1 px-4 py-2 bg-gradient-to-r from-blue-600 to-teal-500 text-white rounded-lg hover:from-blue-700 hover:to-teal-600 transition"
                >
                    Complete Workout
                </button>
                <button 
                    type="button"
                    onclick="document.getElementById('complete-modal').classList.add('hidden')"
                    class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition"
                >
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ProjekLaravel\TrainifyV1\resources\views/user/workouts/show.blade.php ENDPATH**/ ?>