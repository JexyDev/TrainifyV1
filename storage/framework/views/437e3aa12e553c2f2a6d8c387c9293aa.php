<?php $__env->startSection('title', 'Admin Dashboard'); ?>

<?php $__env->startSection('sidebar'); ?>
<div class="space-y-2">
    <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center gap-3 px-4 py-3 bg-gradient-to-r from-blue-600 to-teal-500 text-white rounded-lg">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        <span>Dashboard</span>
    </a>

    <a href="<?php echo e(route('admin.workout-approval')); ?>" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span>Workout Approval</span>
    </a>

    <a href="<?php echo e(route('admin.users.index')); ?>" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
        </svg>
        <span>Manage Users</span>
    </a>

    <a href="<?php echo e(route('admin.categories.index')); ?>" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
        </svg>
        <span>Categories</span>
    </a>

    <a href="<?php echo e(route('admin.levels.index')); ?>" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
        </svg>
        <span>Levels</span>
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Total Users</p>
                <p class="text-3xl font-bold text-gray-900"><?php echo e($stats['total_users']); ?></p>
            </div>
            <div class="p-3 bg-blue-100 rounded-lg">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-teal-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Total Trainers</p>
                <p class="text-3xl font-bold text-gray-900"><?php echo e($stats['total_trainers']); ?></p>
            </div>
            <div class="p-3 bg-teal-100 rounded-lg">
                <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Total Workouts</p>
                <p class="text-3xl font-bold text-gray-900"><?php echo e($stats['total_workouts']); ?></p>
            </div>
            <div class="p-3 bg-purple-100 rounded-lg">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-orange-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Pending Approval</p>
                <p class="text-3xl font-bold text-gray-900"><?php echo e($stats['pending_workouts']); ?></p>
            </div>
            <div class="p-3 bg-orange-100 rounded-lg">
                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
</div>


<!-- Charts dengan Chart.js -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8 h-25">
    <!-- Chart 1: Workout by Category (Pie Chart) -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Workouts by Category</h3>
        <canvas id="categoryChart" height="250"></canvas>
    </div>

    <!-- Chart 2: Workout Completions (Line Chart) -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Workout Completions (7 Days)</h3>
        <canvas id="completionChart" height="100"></canvas>
    </div>
</div>

<!-- Workouts by Category -->


<!-- Chart.js Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Prevent scroll jumping during chart rendering
    let isRendering = false;
    const originalScrollTo = window.scrollTo;
    window.scrollTo = function() {
        if (!isRendering) {
            originalScrollTo.apply(this, arguments);
        }
    };

    // Mark as rendering during chart creation
    const originalChart = Chart;
    Chart = function(...args) {
        isRendering = true;
        const chart = new originalChart(...args);
        setTimeout(() => { isRendering = false; }, 100);
        return chart;
    };
    Chart.prototype = originalChart.prototype;
</script>
<script>
    // Chart 1: Workout by Category (Doughnut Chart)
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const categoryData = <?php echo json_encode($workoutsByCategory, 15, 512) ?>;
    
    new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: categoryData.map(item => item.category),
            datasets: [{
                label: 'Workouts',
                data: categoryData.map(item => item.count),
                backgroundColor: [
                    'rgba(0, 64, 255, 0.8)',
                    'rgba(0, 217, 181, 0.8)',
                    'rgba(147, 51, 234, 0.8)',
                    'rgba(249, 115, 22, 0.8)',
                    'rgba(236, 72, 153, 0.8)',
                    'rgba(34, 197, 94, 0.8)',
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: false, // Disable animations to prevent scroll jumps
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });

    // Chart 2: Workout Completions (Line Chart)
    const completionCtx = document.getElementById('completionChart').getContext('2d');
    const completionData = <?php echo json_encode($workoutCompletions, 15, 512) ?>;
    
    // Generate last 7 days
    const last7Days = [];
    for (let i = 6; i >= 0; i--) {
        const date = new Date();
        date.setDate(date.getDate() - i);
        last7Days.push(date.toISOString().split('T')[0]);
    }
    
    // Map data to last 7 days
    const completionCounts = last7Days.map(date => {
        const found = completionData.find(item => item.date === date);
        return found ? found.count : 0;
    });
    
    new Chart(completionCtx, {
        type: 'line',
        data: {
            labels: last7Days.map(date => {
                const d = new Date(date);
                return d.toLocaleDateString('id-ID', { month: 'short', day: 'numeric' });
            }),
            datasets: [{
                label: 'Completions',
                data: completionCounts,
                borderColor: 'rgba(0, 64, 255, 1)',
                backgroundColor: 'rgba(0, 217, 181, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgba(0, 64, 255, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: false, // Disable animations to prevent scroll jumps
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ProjekLaravel\TrainifyV1\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>