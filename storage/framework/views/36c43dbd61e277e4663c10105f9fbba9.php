<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Progress Workout - <?php echo e($user->name); ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #0040FF;
            padding-bottom: 15px;
        }
        
        .header h1 {
            color: #0040FF;
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .header p {
            color: #666;
            font-size: 11px;
        }
        
        .user-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .user-info h3 {
            color: #0040FF;
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .user-info p {
            font-size: 11px;
            margin-bottom: 5px;
        }
        
        .summary-stats {
            display: table;
            width: 100%;
            margin-bottom: 25px;
        }
        
        .stat-box {
            display: table-cell;
            width: 33.33%;
            text-align: center;
            padding: 15px;
            background: linear-gradient(135deg, #0040FF 0%, #00D9B5 100%);
            color: white;
            border-right: 2px solid white;
        }
        
        .stat-box:last-child {
            border-right: none;
        }
        
        .stat-box .value {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .stat-box .label {
            font-size: 10px;
            opacity: 0.9;
        }
        
        .section-title {
            color: #0040FF;
            font-size: 16px;
            margin: 25px 0 15px 0;
            padding-bottom: 5px;
            border-bottom: 2px solid #00D9B5;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        table thead {
            background: #0040FF;
            color: white;
        }
        
        table th {
            padding: 10px 8px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
        }
        
        table td {
            padding: 8px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 10px;
        }
        
        table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        table tbody tr:hover {
            background: #e3f2fd;
        }
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
        }
        
        .badge-success {
            background: #00D9B5;
            color: white;
        }
        
        .badge-info {
            background: #0040FF;
            color: white;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #999;
            font-size: 10px;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        
        .no-data {
            text-align: center;
            padding: 30px;
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>TRAINIFY</h1>
        <p>Laporan Progress Workout</p>
    </div>

    <!-- User Info -->
    <div class="user-info">
        <h3>Informasi Pengguna</h3>
        <p><strong>Nama:</strong> <?php echo e($user->name); ?></p>
        <p><strong>Email:</strong> <?php echo e($user->email); ?></p>
        <p><strong>Tanggal Cetak:</strong> <?php echo e(now()->locale('id')->isoFormat('dddd, D MMMM Y - HH:mm')); ?> WIB</p>
    </div>

    <!-- Summary Statistics -->
    <div class="summary-stats">
        <div class="stat-box">
            <div class="value"><?php echo e($totalWorkouts); ?></div>
            <div class="label">Total Workout</div>
        </div>
        <div class="stat-box">
            <div class="value"><?php echo e(number_format($totalCalories)); ?></div>
            <div class="label">Total Kalori Terbakar</div>
        </div>
        <div class="stat-box">
            <div class="value"><?php echo e(number_format($totalDuration)); ?></div>
            <div class="label">Total Durasi (menit)</div>
        </div>
    </div>

    <!-- Workout History -->
    <h2 class="section-title">Riwayat Workout</h2>
    
    <?php if($workoutHistory->count() > 0): ?>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 20%;">Tanggal</th>
                    <th style="width: 25%;">Nama Workout</th>
                    <th style="width: 15%;">Kategori</th>
                    <th style="width: 10%;">Level</th>
                    <th style="width: 10%;">Durasi</th>
                    <th style="width: 15%;">Kalori</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $workoutHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $progress): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($index + 1); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($progress->completed_at)->locale('id')->isoFormat('DD MMM Y, HH:mm')); ?></td>
                        <td><strong><?php echo e($progress->workout->title); ?></strong></td>
                        <td>
                            <span class="badge badge-info"><?php echo e($progress->workout->category->name); ?></span>
                        </td>
                        <td>
                            <span class="badge badge-success"><?php echo e($progress->workout->level->name); ?></span>
                        </td>
                        <td><?php echo e($progress->workout->duration); ?> menit</td>
                        <td><?php echo e(number_format($progress->calories_burned)); ?> kkal</td>
                    </tr>
                    <?php if($progress->notes): ?>
                        <tr>
                            <td></td>
                            <td colspan="6" style="font-style: italic; color: #666; font-size: 9px;">
                                <strong>Catatan:</strong> <?php echo e($progress->notes); ?>

                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="no-data">
            Belum ada riwayat workout. Mulai latihan Anda sekarang!
        </div>
    <?php endif; ?>

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini digenerate otomatis oleh sistem Trainify</p>
        <p>© <?php echo e(date('Y')); ?> Trainify - SMK Wikrama Bogor. All rights reserved.</p>
    </div>
</body>
</html>
<?php /**PATH C:\ProjekLaravel\TrainifyV1\resources\views/user/tracking-pdf.blade.php ENDPATH**/ ?>