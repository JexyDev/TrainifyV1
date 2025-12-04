<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\WorkoutApprovalController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Trainer\DashboardController as TrainerDashboardController;
use App\Http\Controllers\Trainer\WorkoutController as TrainerWorkoutController;
use App\Http\Controllers\Trainer\ProfileController as TrainerProfileController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\WorkoutController as UserWorkoutController;
use App\Http\Controllers\User\TrackingController;
use Illuminate\Support\Facades\Route;

// Root Route - Redirect based on auth status
Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isTrainer()) {
            return redirect()->route('trainer.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    }
    return redirect()->route('login');
});

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Authenticated Routes
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Categories (CRUD Master)
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::post('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
    Route::delete('categories/{id}/force-delete', [CategoryController::class, 'forceDelete'])->name('categories.force-delete');
    
    // Levels (CRUD Master)
    Route::resource('levels', LevelController::class)->except(['show']);
    Route::post('levels/{id}/restore', [LevelController::class, 'restore'])->name('levels.restore');
    Route::delete('levels/{id}/force-delete', [LevelController::class, 'forceDelete'])->name('levels.force-delete');
    
    // Workout Approval
    Route::get('/workout-approval', [WorkoutApprovalController::class, 'index'])->name('workout-approval');
    Route::post('/workouts/{workout}/approve', [WorkoutApprovalController::class, 'approve'])->name('workouts.approve');
    Route::post('/workouts/{workout}/reject', [WorkoutApprovalController::class, 'reject'])->name('workouts.reject');
    
    // User Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{id}/restore', [AdminUserController::class, 'restore'])->name('users.restore');
    Route::delete('/users/{id}/force-delete', [AdminUserController::class, 'forceDelete'])->name('users.force-delete');
});

// Trainer Routes
Route::middleware(['auth', 'trainer'])->prefix('trainer')->name('trainer.')->group(function () {
    Route::get('/dashboard', [TrainerDashboardController::class, 'index'])->name('dashboard');
    
    // Workouts (CRUD with Relations)
    Route::resource('workouts', TrainerWorkoutController::class);
    
    // Profile
    Route::get('/profile', [TrainerProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [TrainerProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [TrainerProfileController::class, 'updatePassword'])->name('profile.password');
});

// User Routes
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    
    // Workouts
    Route::get('/workouts', [UserWorkoutController::class, 'index'])->name('workouts.index');
    Route::get('/workouts/{workout}', [UserWorkoutController::class, 'show'])->name('workouts.show');
    Route::post('/workouts/{workout}/complete', [UserWorkoutController::class, 'complete'])->name('workouts.complete');
    
    // Tracking & Export
    Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking');
    Route::get('/tracking/export/excel', [TrackingController::class, 'exportExcel'])->name('tracking.export.excel');
    Route::get('/tracking/export/pdf', [TrackingController::class, 'exportPdf'])->name('tracking.export.pdf');
});