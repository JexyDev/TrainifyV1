# 📊 PENJELASAN RUBRIK PENILAIAN - TRAINIFY

## Mapping File dengan Rubrik Penilaian

### 1. ✅ ERD & Class Diagram (10 poin)

**File terkait:**
- `database/migrations/*` - 6 migrations dengan relasi lengkap
- Database structure sudah normalized:
  - `users` (1 tabel untuk 3 role)
  - `categories` (master data)
  - `levels` (master data)
  - `workouts` (relasi ke trainer, category, level)
  - `exercises` (relasi ke workout)
  - `user_workout_progress` (many-to-many)

**Relasi:**
- One to Many: User → Workouts, Workout → Exercises
- Many to Many: User ←→ Workouts (via user_workout_progress)
- Belongs To: Workout → Category, Workout → Level

### 2. ✅ User Flow (5 poin)

**File terkait:**
- `routes/web.php` - Semua route dengan middleware
- Flow:
  1. Guest → Login/Register
  2. Auth → Redirect by role
  3. Admin → Dashboard, CRUD, Approval
  4. Trainer → Create Workout → Pending → Admin Approve
  5. User → Browse → Complete → Export

### 3. ✅ Migration, Model, Controller (10 poin)

**Migrations (6 files):**
```
database/migrations/
├── 2024_01_01_000001_create_categories_table.php
├── 2024_01_01_000002_create_levels_table.php
├── 2024_01_01_000003_add_trainify_fields_to_users_table.php
├── 2024_01_01_000004_create_workouts_table.php
├── 2024_01_01_000005_create_exercises_table.php
└── 2024_01_01_000006_create_user_workout_progress_table.php
```

**Models (6 files dengan relasi):**
```
app/Models/
├── User.php (relasi: workouts, workoutProgress, completedWorkouts)
├── Category.php (relasi: workouts)
├── Level.php (relasi: workouts)
├── Workout.php (relasi: trainer, category, level, exercises, userProgress)
├── Exercise.php (relasi: workout)
└── UserWorkoutProgress.php (relasi: user, workout)
```

**Controllers (terstruktur per role):**
```
app/Http/Controllers/
├── Auth/
│   ├── LoginController.php
│   └── RegisterController.php
├── Admin/
│   ├── DashboardController.php
│   ├── CategoryController.php (CRUD)
│   ├── LevelController.php (CRUD)
│   ├── WorkoutApprovalController.php
│   └── UserController.php (soft delete)
├── Trainer/
│   ├── DashboardController.php
│   ├── WorkoutController.php (CRUD dengan relasi)
│   └── ProfileController.php
└── User/
    ├── DashboardController.php
    ├── WorkoutController.php
    └── TrackingController.php (export)
```

### 4. ✅ Blade Template (5 poin)

**File terkait:**
```
resources/views/
├── layouts/
│   ├── app.blade.php (main layout)
│   └── dashboard.blade.php (dashboard layout dengan sidebar)
├── auth/
│   └── login.blade.php
├── admin/
│   ├── dashboard.blade.php
│   ├── categories/ (CRUD views)
│   └── partials/sidebar.blade.php
├── trainer/ (views untuk trainer)
└── user/ (views untuk user)
```

**Features:**
- Component-based dengan `@extends`, `@section`, `@yield`
- Reusable sidebar dengan `@include`
- Blade directives lengkap

### 5. ✅ Authentication (10 poin)

**File terkait:**
- `app/Http/Controllers/Auth/LoginController.php`
- `app/Http/Controllers/Auth/RegisterController.php`

**Features:**
- ❌ TIDAK pakai Laravel Breeze (manual)
- ✅ Login dengan redirect berdasarkan role
- ✅ Register dengan validation
- ✅ Logout dengan session invalidate
- ✅ Password hashing (Hash::make)
- ✅ Remember me checkbox

### 6. ✅ Middleware (10 poin)

**File terkait:**
```
app/Http/Middleware/
├── AdminMiddleware.php
├── TrainerMiddleware.php
└── UserMiddleware.php
```

**Registered di:** `bootstrap/app.php`

**Cara kerja:**
- Admin routes: `Route::middleware(['auth', 'admin'])`
- Trainer routes: `Route::middleware(['auth', 'trainer'])`
- User routes: `Route::middleware(['auth', 'user'])`
- Jika role tidak sesuai → abort(403)

### 7. ✅ CRUD Master (20 poin)

**Categories CRUD:**
- ✅ Create: `CategoryController@store`
- ✅ Read: `CategoryController@index`
- ✅ Update: `CategoryController@update`
- ✅ Delete: `CategoryController@destroy` (soft delete)
- ✅ Validation di semua form
- ✅ Auto slug generation

**Levels CRUD:**
- ✅ Sama seperti Categories
- ✅ File: `app/Http/Controllers/Admin/LevelController.php`

**Form validation:**
```php
$validated = $request->validate([
    'name' => ['required', 'string', 'max:255', 'unique:categories'],
]);
```

### 8. ✅ Storage (5 poin)

**File terkait:**
- `app/Http/Controllers/Trainer/WorkoutController.php`
- `app/Http/Controllers/Trainer/ProfileController.php`

**Features:**
```php
// Upload workout image
if ($request->hasFile('image')) {
    $imagePath = $request->file('image')->store('workouts', 'public');
}

// Upload avatar
if ($request->hasFile('avatar')) {
    $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
}
```

**Storage symlink:**
```bash
php artisan storage:link
```

**File tersimpan di:** `storage/app/public/`
**Diakses via:** `public/storage/`

### 9. ✅ Export Excel (10 poin)

**File terkait:**
- `app/Exports/UserProgressExport.php`
- `app/Http/Controllers/User/TrackingController.php`

**Package:** `maatwebsite/excel`

**Features:**
```php
// Export to .xlsx
return Excel::download(new UserProgressExport(auth()->id()), 'my-workout-progress.xlsx');
```

**Data yang di-export:**
- Tanggal complete
- Nama workout
- Kategori
- Durasi
- Kalori terbakar
- Catatan

### 10. ✅ Relasi (10 poin)

**Workout CRUD dengan Exercise (One-to-Many):**

**File:** `app/Http/Controllers/Trainer/WorkoutController.php`

```php
// Create workout dengan exercises
$workout = auth()->user()->workouts()->create([...]);

// Create exercises (relasi)
foreach ($validated['exercises'] as $exerciseData) {
    $workout->exercises()->create([...]);
}

// Load dengan relasi (Eager Loading)
$workout->load(['category', 'level', 'trainer', 'exercises']);
```

**User-Workout Progress (Many-to-Many):**

**File:** `app/Models/User.php`

```php
public function completedWorkouts()
{
    return $this->belongsToMany(Workout::class, 'user_workout_progress')
                ->withPivot('completed_at', 'calories_burned', 'notes')
                ->withTimestamps();
}
```

### 11. ✅ Soft Deletes (5 poin)

**File terkait:**
- Semua Models: `use SoftDeletes;`
- Controllers: restore & forceDelete methods

**Features:**
```php
// Soft delete
$category->delete();

// Restore
$category = Category::onlyTrashed()->findOrFail($id);
$category->restore();

// Force delete (permanent)
$category->forceDelete();
```

**Views:**
- Menampilkan deleted data
- Tombol Restore
- Tombol Delete Permanent

---

## 📝 CARA PRESENTASI

### 1. Login (Authentication)
```
Login sebagai Admin → auto redirect ke admin/dashboard
Login sebagai Trainer → auto redirect ke trainer/dashboard  
Login sebagai User → auto redirect ke user/dashboard
```

### 2. CRUD Master (Categories)
```
Admin → Categories → Tambah Category
Isi form → Submit → Muncul di tabel
Edit category → Update berhasil
Delete → Soft delete → Muncul di "Deleted Categories"
Restore → Kembali ke active
Force Delete → Hilang permanent
```

### 3. CRUD Relasi (Workouts)
```
Trainer → Add Workout
Isi form: title, description, category, level, duration
Tambah multiple exercises (nama, sets, reps, rest)
Submit → Status "Pending" (menunggu approval admin)
```

### 4. Storage (Upload File)
```
Trainer → Edit Workout → Upload gambar
File tersimpan di storage/app/public/workouts/
```

### 5. Approval Workflow (Middleware + Status)
```
Admin → Workout Approval
Lihat pending workouts dari trainer
Approve → Status jadi "Approved" → Muncul di User dashboard
```

### 6. Export Excel
```
User → Tracking
Klik "Export to Excel"
Download file .xlsx berisi workout progress
```

### 7. Tunjukkan Code
```
Buka CategoryController → Explain CRUD
Buka Workout Model → Explain relasi
Buka AdminMiddleware → Explain role check
Buka migration → Explain foreign keys
```

---

## 🎯 TOTAL POIN

| No | Aspek | Poin | Status |
|----|-------|------|--------|
| 1 | ERD & Class Diagram | 10 | ✅ |
| 2 | User Flow | 5 | ✅ |
| 3 | Migration, Model, Controller | 10 | ✅ |
| 4 | Blade | 5 | ✅ |
| 5 | Authentication | 10 | ✅ |
| 6 | Middleware | 10 | ✅ |
| 7 | CRUD Master | 20 | ✅ |
| 8 | Storage | 5 | ✅ |
| 9 | Export Excel | 10 | ✅ |
| 10 | Relasi | 10 | ✅ |
| 11 | Soft Deletes | 5 | ✅ |
| **TOTAL** | | **100** | **✅** |

---

**Semua rubrik terpenuhi! Good luck untuk presentasi! 🚀**
