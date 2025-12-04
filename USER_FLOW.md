# 🔄 TRAINIFY - USER FLOW DOCUMENTATION

## 📋 Overview

Trainify memiliki **3 Role User** dengan alur yang berbeda:
1. **Admin** - Mengelola sistem, approve workout, manage users
2. **Trainer** - Membuat dan mengelola workout programs
3. **User (Member)** - Mengikuti workout dan tracking progress

---

## 🎯 COMPLETE USER FLOW DIAGRAM

```
┌─────────────────────────────────────────────────────────────────┐
│                      APLIKASI TRAINIFY                          │
│                   (Workout Tracker System)                      │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│                     LANDING PAGE (/)                            │
│                                                                 │
│  • Jika belum login → redirect ke /login                       │
│  • Jika sudah login → redirect berdasarkan role:               │
│    - Admin → /admin/dashboard                                  │
│    - Trainer → /trainer/dashboard                              │
│    - User → /user/dashboard                                    │
└─────────────────────────────────────────────────────────────────┘
                              ↓
                    ┌─────────┴─────────┐
                    │                   │
              GUEST USER          AUTHENTICATED USER
                    │                   │
                    ↓                   ↓
        ┌───────────────────┐   ┌──────────────────┐
        │  1. Login Page    │   │  Role-Based      │
        │  2. Register Page │   │  Dashboard       │
        └───────────────────┘   └──────────────────┘
```

---

## 1️⃣ GUEST USER FLOW (Belum Login)

### A. Registration Flow (Daftar Akun Baru)

```
START → /register (GET)
   │
   ├─→ Form Input:
   │   ├─ Name (required)
   │   ├─ Email (required, unique)
   │   ├─ Password (required, min 8 char)
   │   ├─ Password Confirmation (required)
   │   └─ Role Selection:
   │       ├─ User (Member) - default
   │       └─ Trainer
   │
   ├─→ POST /register
   │   │
   │   ├─→ Validation:
   │   │   ├─ Email sudah terdaftar? → Error
   │   │   ├─ Password tidak match? → Error
   │   │   └─ Validasi lainnya
   │   │
   │   └─→ Success:
   │       ├─ User created di database
   │       ├─ Auto login
   │       └─ Redirect berdasarkan role:
   │           ├─ Trainer → /trainer/dashboard
   │           └─ User → /user/dashboard
   │
END
```

**File Terkait:**
- Route: `routes/web.php` (line 27-28)
- Controller: `app/Http/Controllers/Auth/RegisterController.php`
- View: `resources/views/auth/register.blade.php`
- Model: `app/Models/User.php`

---

### B. Login Flow (Masuk ke Akun)

```
START → /login (GET)
   │
   ├─→ Form Input:
   │   ├─ Email (required)
   │   ├─ Password (required)
   │   └─ Remember Me (optional checkbox)
   │
   ├─→ POST /login
   │   │
   │   ├─→ Validation:
   │   │   ├─ Email not found? → Error
   │   │   ├─ Password salah? → Error
   │   │   └─ Account deleted (soft delete)? → Error
   │   │
   │   └─→ Success:
   │       ├─ Session created
   │       ├─ Check user role
   │       └─ Redirect berdasarkan role:
   │           ├─ Admin → /admin/dashboard
   │           ├─ Trainer → /trainer/dashboard
   │           └─ User → /user/dashboard
   │
END
```

**File Terkait:**
- Route: `routes/web.php` (line 24-25)
- Controller: `app/Http/Controllers/Auth/LoginController.php`
- View: `resources/views/auth/login.blade.php`
- Middleware: Laravel built-in auth middleware

---

## 2️⃣ ADMIN USER FLOW

### Dashboard Overview

```
/admin/dashboard (AdminDashboard)
   │
   ├─→ View Statistics:
   │   ├─ Total Users
   │   ├─ Total Trainers
   │   ├─ Total Workouts
   │   ├─ Pending Approvals
   │   └─ Active Members
   │
   ├─→ Quick Actions:
   │   ├─ Workout Approval
   │   ├─ Manage Categories
   │   ├─ Manage Levels
   │   └─ Manage Users
   │
   └─→ Recent Activity Feed
```

**File Terkait:**
- Route: `routes/web.php` (line 36)
- Controller: `app/Http/Controllers/Admin/DashboardController.php`
- View: `resources/views/admin/dashboard.blade.php`
- Sidebar: `resources/views/admin/partials/sidebar.blade.php`

---

### A. CRUD Categories (Master Data)

```
┌──────────────────────────────────────────────────────────────┐
│  /admin/categories (Index - List All)                       │
└──────────────────────────────────────────────────────────────┘
   │
   ├─→ [+ Tambah Category] → /admin/categories/create (GET)
   │                          │
   │                          ├─→ Form Input:
   │                          │   └─ Name (Strength, Cardio, Yoga, dll)
   │                          │
   │                          ├─→ POST /admin/categories
   │                          │   ├─ Validation
   │                          │   ├─ Auto generate slug
   │                          │   └─ Save to database
   │                          │
   │                          └─→ Redirect ke /admin/categories
   │
   ├─→ [Edit] → /admin/categories/{id}/edit (GET)
   │             │
   │             ├─→ Form with existing data
   │             │
   │             ├─→ PUT /admin/categories/{id}
   │             │   ├─ Validation
   │             │   ├─ Update slug if name changed
   │             │   └─ Update database
   │             │
   │             └─→ Redirect ke /admin/categories
   │
   ├─→ [Delete] → DELETE /admin/categories/{id}
   │              │
   │              ├─→ Soft Delete (deleted_at timestamp)
   │              ├─→ Record moved to "Deleted Categories" section
   │              └─→ Redirect back
   │
   ├─→ [Restore] → POST /admin/categories/{id}/restore
   │               │
   │               ├─→ Restore soft deleted record
   │               └─→ Redirect back
   │
   └─→ [Force Delete] → DELETE /admin/categories/{id}/force-delete
                        │
                        ├─→ Permanent delete from database
                        └─→ Redirect back
```

**File Terkait:**
- Route: `routes/web.php` (line 39-41)
- Controller: `app/Http/Controllers/Admin/CategoryController.php`
- Views:
  - `resources/views/admin/categories/index.blade.php`
  - `resources/views/admin/categories/create.blade.php`
  - `resources/views/admin/categories/edit.blade.php`
- Model: `app/Models/Category.php` (with SoftDeletes)
- Migration: `database/migrations/2024_01_01_000001_create_categories_table.php`

---

### B. CRUD Levels (Master Data)

```
┌──────────────────────────────────────────────────────────────┐
│  /admin/levels (Index - List All)                           │
└──────────────────────────────────────────────────────────────┘
   │
   ├���→ [+ Tambah Level] → /admin/levels/create (GET)
   │                       │
   │                       ├─→ Form Input:
   │                       │   └─ Name (Beginner, Intermediate, Advanced)
   │                       │
   │                       ├─→ POST /admin/levels
   │                       │   ├─ Validation
   │                       │   ├─ Auto generate slug
   │                       │   └─ Save to database
   │                       │
   │                       └─→ Redirect ke /admin/levels
   │
   ├─→ [Edit] → /admin/levels/{id}/edit (GET)
   │             │
   │             ├─→ Form with existing data
   │             │
   │             ├─→ PUT /admin/levels/{id}
   │             │   ├─ Update data
   │             │   └─ Update slug
   │             │
   │             └─→ Redirect ke /admin/levels
   │
   ├─→ [Delete] → Soft Delete (sama seperti Categories)
   ├─→ [Restore] → Restore deleted level
   └─→ [Force Delete] → Permanent delete
```

**File Terkait:**
- Route: `routes/web.php` (line 44-46)
- Controller: `app/Http/Controllers/Admin/LevelController.php`
- Views: `resources/views/admin/levels/*.blade.php`
- Model: `app/Models/Level.php` (with SoftDeletes)

---

### C. Workout Approval Flow

```
┌──────────────────────────────────────────────────────────────┐
│  /admin/workout-approval                                     │
└──────────────────────────────────────────────────────────────┘
   │
   ├─→ View Pending Workouts:
   │   ├─ Workout Title
   │   ├─ Trainer Name
   │   ├─ Category & Level
   │   ├─ Duration
   │   ├─ Exercises List Preview
   │   └─ Image (if uploaded)
   │
   ├─→ [Approve] → POST /admin/workouts/{id}/approve
   │               │
   │               ├─ Update status: 'pending' → 'approved'
   │               ├─ Workout visible to all users
   │               └─ Flash message: "Workout approved!"
   │
   ├─→ [Reject] → POST /admin/workouts/{id}/reject
   │              │
   │              ├─ Update status: 'pending' → 'rejected'
   │              ├─ Trainer can see rejection
   │              └─ Flash message: "Workout rejected"
   │
   └─→ View Recently Approved:
       └─ Table of approved workouts
```

**File Terkait:**
- Route: `routes/web.php` (line 49-51)
- Controller: `app/Http/Controllers/Admin/WorkoutApprovalController.php`
- View: `resources/views/admin/workout-approval.blade.php`
- Model: `app/Models/Workout.php` (status: pending/approved/rejected)

---

### D. Manage Users Flow

```
┌──────────────────────────────────────────────────────────────┐
│  /admin/users                                                │
└──────────────────────────────────────────────────────────────┘
   │
   ├─→ View All Users:
   │   ├─ Search by name/email
   │   ├─ Filter by role (Admin/Trainer/User)
   │   └─ User info: Name, Email, Role, Join Date
   │
   ├─→ [Delete User] → DELETE /admin/users/{id}
   │                   │
   │                   ├─ Soft Delete user
   │                   ├─ User cannot login
   │                   └─ Redirect back
   │
   ├─→ View Deleted Users (Soft Delete):
   │   └─ List of deleted users with deleted_at timestamp
   │
   ├─→ [Restore User] → POST /admin/users/{id}/restore
   │                    │
   │                    ├─ Restore user account
   │                    └─ User can login again
   │
   └─→ [Force Delete] → DELETE /admin/users/{id}/force-delete
                        │
                        ├─ Permanent delete
                        └─ All user data removed
```

**File Terkait:**
- Route: `routes/web.php` (line 54-57)
- Controller: `app/Http/Controllers/Admin/UserController.php`
- View: `resources/views/admin/users/index.blade.php`
- Model: `app/Models/User.php` (with SoftDeletes)

---

### E. Logout Flow

```
Any Admin Page → [Logout Button]
   │
   └─→ POST /logout
       │
       ├─ Destroy session
       ├─ Clear auth cookies
       └─ Redirect to /login
```

---

## 3️⃣ TRAINER USER FLOW

### Dashboard Overview

```
/trainer/dashboard (TrainerDashboard)
   │
   ├─→ View Statistics:
   │   ├─ Total Workouts Created
   │   ├─ Approved Workouts
   │   ├─ Pending Workouts
   │   └─ Rejected Workouts
   │
   ├─→ Quick Actions:
   │   ├─ [+ Create New Workout]
   │   └─ [View All Workouts]
   │
   └─→ Recent Workouts Table:
       ├─ Title
       ├─ Category & Level
       ├─ Duration
       └─ Status (Pending/Approved/Rejected)
```

**File Terkait:**
- Route: `routes/web.php` (line 62)
- Controller: `app/Http/Controllers/Trainer/DashboardController.php`
- View: `resources/views/trainer/dashboard.blade.php`
- Sidebar: `resources/views/trainer/partials/sidebar.blade.php`

---

### A. Create Workout Flow (CRUD dengan Relasi)

```
┌──────────────────────────────────────────────────────────────┐
│  /trainer/workouts/create                                    │
└──────────────────────────────────────────────────────────────┘
   │
   ├─→ Form Workout Information:
   │   ├─ Title (required)
   │   ├─ Description (required)
   │   ├─ Category (dropdown - relasi)
   │   ├─ Level (dropdown - relasi)
   │   ├─ Duration (minutes, required)
   │   └─ Image Upload (optional, Storage)
   │
   ├─→ Dynamic Exercises Section:
   │   │
   │   ├─→ [+ Add Exercise] Button
   │   │   │
   │   │   └─→ JavaScript adds new exercise row:
   │   │       ├─ Exercise Name (required)
   │   │       ├─ Sets (number, required)
   │   │       ├─ Reps (text, required - "10" or "10-12")
   │   │       ├─ Rest Seconds (number, required)
   │   │       └─ [Remove] button
   │   │
   │   └─→ Can add multiple exercises (One-to-Many relation)
   │
   ├─→ POST /trainer/workouts
   │   │
   │   ├─→ Validation:
   │   │   ├─ All fields required
   │   │   ├─ Image max 2MB (jpg, png, gif)
   │   │   └─ At least 1 exercise required
   │   │
   │   ├─→ Process:
   │   │   ├─ Upload image to storage/app/public/workouts/
   │   │   ├─ Create Workout record (status: 'pending')
   │   │   ├─ Create related Exercise records (One-to-Many)
   │   │   └─ Auto set trainer_id = auth()->id()
   │   │
   │   └─→ Success:
   │       ├─ Flash message: "Workout created! Waiting for admin approval"
   │       └─ Redirect to /trainer/workouts
   │
END
```

**File Terkait:**
- Route: `routes/web.php` (line 65 - resource route)
- Controller: `app/Http/Controllers/Trainer/WorkoutController.php` (store method)
- View: `resources/views/trainer/workouts/create.blade.php`
- Models:
  - `app/Models/Workout.php` (hasMany exercises)
  - `app/Models/Exercise.php` (belongsTo workout)
- Migration:
  - `database/migrations/2024_01_01_000004_create_workouts_table.php`
  - `database/migrations/2024_01_01_000005_create_exercises_table.php`

---

### B. Edit Workout Flow

```
┌──────────────────────────────────────────────────────────────┐
│  /trainer/workouts (Index/List)                             │
└──────────────────────────────────────────────────────────────┘
   │
   └─→ [Edit Button] → /trainer/workouts/{id}/edit (GET)
                       │
                       ├─→ Load existing data:
                       │   ├─ Workout info
                       │   └─ All exercises (One-to-Many relation)
                       │
                       ├─→ Form (same as Create):
                       │   ├─ Can modify workout info
                       │   ├─ Can add/remove exercises
                       │   └─ Can change image
                       │
                       ├─→ PUT /trainer/workouts/{id}
                       │   │
                       │   ├─→ If workout status was 'approved':
                       │   │   └─ Reset status to 'pending'
                       │   │       (needs re-approval from admin)
                       │   │
                       │   ├─→ Update Workout
                       │   ├─→ Delete old exercises
                       │   ├─→ Create new exercises
                       │   └─→ Update image if new file uploaded
                       │
                       └─→ Redirect to /trainer/workouts
```

**File Terkait:**
- Controller: `app/Http/Controllers/Trainer/WorkoutController.php` (edit, update methods)
- View: `resources/views/trainer/workouts/edit.blade.php`

---

### C. View My Workouts Flow

```
┌──────────────────────────────────────────────────────────────┐
│  /trainer/workouts (Index)                                  │
└──────────────────────────────────────────────────────────────┘
   │
   ├─→ Display Grid/List of Workouts:
   │   ├─ Image thumbnail
   │   ├─ Title
   │   ├─ Description (truncated)
   │   ├─ Category & Level badges
   │   ├─ Duration
   │   ├─ Exercise count
   │   └─ Status badge:
   │       ├─ 🟢 Approved (green)
   │       ├─ 🟠 Pending (orange)
   │       └─ 🔴 Rejected (red)
   │
   ├─→ Action Buttons:
   │   ├─ [Edit] → /trainer/workouts/{id}/edit
   │   └─ [Delete] → DELETE /trainer/workouts/{id}
   │                 │
   │                 ├─ Confirm dialog
   │                 ├─ Delete workout & all exercises (cascade)
   │                 └─ Redirect back
   │
   └─→ Empty State:
       └─ "Belum ada workout. [Create Your First Workout]"
```

**File Terkait:**
- Controller: `app/Http/Controllers/Trainer/WorkoutController.php` (index method)
- View: `resources/views/trainer/workouts/index.blade.php`

---

### D. Edit Profile Flow (dengan Upload Avatar)

```
┌──────────────────────────────────────────────────────────────┐
│  /trainer/profile (Edit Profile)                            │
└──────────────────────────────────────────────────────────────┘
   │
   ├─→ Section 1: Profile Information
   │   │
   │   ├─→ Form Fields:
   │   │   ├─ Name (required)
   │   │   ├─ Email (required, unique)
   │   │   ├─ Phone (optional)
   │   │   ├─ Bio (textarea, optional)
   │   │   ├─ Specialization (optional)
   │   │   ├─ Certifications (optional)
   │   │   └─ Avatar Upload (image, Storage)
   │   │
   │   └─→ PUT /trainer/profile
   │       │
   │       ├─ Validation
   │       ├─ Upload avatar to storage/app/public/avatars/
   │       ├─ Update User record
   │       └─ Flash message: "Profile updated!"
   │
   └─→ Section 2: Change Password
       │
       ├─→ Form Fields:
       │   ├─ Current Password (required)
       │   ├─ New Password (required, min 8)
       │   └─ Confirm New Password (required)
       │
       └─→ PUT /trainer/profile/password
           │
           ├─ Validate current password matches
           ├─ Hash new password
           ├─ Update User record
           └─ Flash message: "Password changed!"
```

**File Terkait:**
- Route: `routes/web.php` (line 68-70)
- Controller: `app/Http/Controllers/Trainer/ProfileController.php`
- View: `resources/views/trainer/profile.blade.php`
- Storage: `storage/app/public/avatars/`

---

## 4️⃣ USER (MEMBER) FLOW

### Dashboard Overview

```
/user/dashboard (UserDashboard)
   │
   ├─→ Statistics Cards:
   │   ├─ Workouts Completed (count)
   │   ├─ Calories Burned (sum)
   │   └─ Active Minutes (sum)
   │
   ├─→ Recent Activity:
   │   └─ List of completed workouts with:
   │       ├─ Workout title
   │       ├─ Category badge
   │       ├─ Completion time (diffForHumans)
   │       └─ Calories burned
   │
   └─→ Recommended Workouts:
       └─ Grid of approved workouts (max 6)
           └─ [View All] → /user/workouts
```

**File Terkait:**
- Route: `routes/web.php` (line 75)
- Controller: `app/Http/Controllers/User/DashboardController.php`
- View: `resources/views/user/dashboard.blade.php`
- Sidebar: `resources/views/user/partials/sidebar.blade.php`

---

### A. Browse Workouts Flow

```
┌──────────────────────────────────────────────────────────────┐
│  /user/workouts (Browse All Approved Workouts)              │
└──────────────────────────────────────────────────────────────┘
   │
   ├─→ Filter Section:
   │   ├─ Category (dropdown)
   │   ├─ Level (dropdown)
   │   ├─ Duration:
   │   │   ├─ Short (<30 min)
   │   │   ├─ Medium (30-45 min)
   │   │   └─ Long (>45 min)
   │   └─ [Apply Filters] button
   │
   ├─→ Workout Grid:
   │   │
   │   └─→ Each Card Shows:
   │       ├─ Image
   │       ├─ Title
   │       ├─ Description (truncated)
   │       ├─ Category & Level badges
   │       ├─ Duration badge (top-right)
   │       ├─ Trainer name
   │       └─ [Click to View Details]
   │
   ├─→ Click Card → /user/workouts/{id}
   │
   └─→ Empty State:
       └─ "No workouts found matching your filters"
```

**File Terkait:**
- Route: `routes/web.php` (line 78)
- Controller: `app/Http/Controllers/User/WorkoutController.php` (index method)
- View: `resources/views/user/workouts/index.blade.php`

---

### B. View Workout Detail & Complete Flow

```
┌──────────────────────────────────────────────────────────────┐
│  /user/workouts/{id} (Workout Detail)                       │
└──────────────────────────────────────────────────────────────┘
   │
   ├─→ Workout Header:
   │   ├─ Full-size image
   │   ├─ Title
   │   ├─ Category & Level & Duration
   │   ├─ Trainer name
   │   ├─ Description (full)
   │   └─ Completion Status:
   │       └─ If already completed:
   │           ├─ ✓ Completed on [date]
   │           └─ Calories burned: [amount]
   │
   ├─→ Exercises List:
   │   │
   │   └─→ For each exercise:
   │       ├─ Number. Exercise Name
   │       ├─ Sets x Reps
   │       └─ Rest time
   │
   ├─→ [Start Workout] / [Complete Again] Button
   │   │
   │   └─→ Opens Modal:
   │       │
   │       ├─→ Form Fields:
   │       │   ├─ Calories Burned (optional, number)
   │       │   └─ Notes (optional, textarea)
   │       │
   │       ├─→ [Complete Workout] button
   │       │   │
   │       │   └─→ POST /user/workouts/{id}/complete
   │       │       │
   │       │       ├─ Create UserWorkoutProgress record:
   │       │       │   ├─ user_id
   │       │       │   ├─ workout_id
   │       │       │   ├─ completed_at (now)
   │       │       │   ├─ calories_burned
   │       │       │   └─ notes
   │       │       │
   │       │       ├─ Flash message: "Workout completed! 🎉"
   │       │       └─ Redirect to /user/tracking
   │       │
   │       └─→ [Cancel] button → Close modal
   │
END
```

**File Terkait:**
- Route: `routes/web.php` (line 79-80)
- Controller: `app/Http/Controllers/User/WorkoutController.php` (show, complete methods)
- View: `resources/views/user/workouts/show.blade.php`
- Model: `app/Models/UserWorkoutProgress.php`
- Migration: `database/migrations/2024_01_01_000006_create_user_workout_progress_table.php`
- Relasi: Many-to-Many (User ↔ Workout through user_workout_progress)

---

### C. Tracking & Export Flow

```
┌──────────────────────────────────────────────────────────────┐
│  /user/tracking (My Progress)                               │
└──────────────────────────────────────────────────────────────┘
   │
   ├─→ Header:
   │   └─ [Export to Excel] button
   │       │
   │       └─→ GET /user/tracking/export
   │           │
   │           ├─ Generate Excel using Maatwebsite/Excel
   │           ├─ Columns:
   │           │   ├─ Date
   │           │   ├─ Workout Title
   │           │   ├─ Category
   │           │   ├─ Duration
   │           │   ├─ Calories Burned
   │           │   └─ Notes
   │           │
   │           └─ Download: trainify_progress_[date].xlsx
   │
   ├─→ Weekly Stats Chart:
   │   └─ Bar chart showing workouts per day (last 7 days)
   │
   ├─→ Workout History Table:
   │   │
   │   └─→ Columns:
   │       ├─ Date & Time
   │       ├─ Workout Title
   │       ├─ Category badge
   │       ├─ Duration
   │       ├─ Calories Burned
   │       └─ Notes
   │
   ├─→ Pagination:
   │   └─ 15 records per page
   │
   └─→ Empty State:
       └─ "No workout history yet. [Start your first workout]"
```

**File Terkait:**
- Route: `routes/web.php` (line 83-84)
- Controller: `app/Http/Controllers/User/TrackingController.php`
- View: `resources/views/user/tracking.blade.php`
- Export: `app/Exports/UserProgressExport.php`
- Package: `maatwebsite/excel` (composer dependency)

---

## 🔐 MIDDLEWARE & ACCESS CONTROL

### Authentication Check

```
All Protected Routes
   │
   ├─→ Middleware: 'auth'
   │   │
   │   ├─ Check if user is logged in
   │   │
   │   ├─→ YES → Continue to role check
   │   │
   │   └─→ NO → Redirect to /login
```

### Role-Based Access Control

```
Route Group with Role Middleware
   │
   ├─→ Admin Routes → Middleware: ['auth', 'admin']
   │   │
   │   └─→ AdminMiddleware.php:
   │       ├─ Check if auth()->user()->isAdmin()
   │       ├─→ YES → Allow access
   │       └─→ NO → Abort 403 Unauthorized
   │
   ├─→ Trainer Routes → Middleware: ['auth', 'trainer']
   │   │
   │   └─→ TrainerMiddleware.php:
   │       ├─ Check if auth()->user()->isTrainer()
   │       ├─→ YES → Allow access
   │       └─→ NO → Abort 403 Unauthorized
   │
   └─→ User Routes → Middleware: ['auth', 'user']
       │
       └─→ UserMiddleware.php:
           ├─ Check if auth()->user()->isUser()
           ├─→ YES → Allow access
           └─→ NO → Abort 403 Unauthorized
```

**File Terkait:**
- `app/Http/Middleware/AdminMiddleware.php`
- `app/Http/Middleware/TrainerMiddleware.php`
- `app/Http/Middleware/UserMiddleware.php`
- `bootstrap/app.php` (register middleware alias)
- `routes/web.php` (apply middleware to route groups)

---

## 📊 DATABASE RELATIONSHIPS FLOW

### Relasi One-to-Many (Workout → Exercises)

```
Trainer Creates Workout
   │
   ├─→ workouts table:
   │   ├─ id: 1
   │   ├─ title: "Full Body HIIT"
   │   ├─ trainer_id: 2
   │   ├─ category_id: 1
   │   └─ level_id: 2
   │
   └─→ exercises table (MULTIPLE):
       ├─ id: 1, workout_id: 1, name: "Push-ups", sets: 3, reps: "10"
       ├─ id: 2, workout_id: 1, name: "Squats", sets: 4, reps: "15"
       └─ id: 3, workout_id: 1, name: "Plank", sets: 3, reps: "30s"

Query in Controller:
  $workout = Workout::with('exercises')->find(1);
  $workout->exercises; // Returns collection of 3 exercises
```

**File Terkait:**
- Model: `app/Models/Workout.php` → `hasMany(Exercise::class)`
- Model: `app/Models/Exercise.php` → `belongsTo(Workout::class)`

---

### Relasi Many-to-Many (User ↔ Workout)

```
User Completes Multiple Workouts
   │
   ├─→ users table:
   │   └─ id: 5, name: "John Doe", role: "user"
   │
   ├─→ workouts table:
   │   ├─ id: 1, title: "Morning Yoga"
   │   └─ id: 2, title: "Evening Run"
   │
   └─→ user_workout_progress table (PIVOT):
       ├─ user_id: 5, workout_id: 1, completed_at: "2024-01-15", calories: 200
       └─ user_id: 5, workout_id: 2, completed_at: "2024-01-16", calories: 350

Query in Controller:
  $user = User::with('completedWorkouts')->find(5);
  $user->completedWorkouts; // Returns collection of 2 workouts
  
  $user->workoutProgress; // Returns 2 UserWorkoutProgress records
```

**File Terkait:**
- Model: `app/Models/User.php` → `belongsToMany(Workout::class, 'user_workout_progress')`
- Model: `app/Models/UserWorkoutProgress.php` → Pivot model
- Migration: `database/migrations/2024_01_01_000006_create_user_workout_progress_table.php`

---

## 🗄️ FILE STORAGE FLOW

### Upload Workout Image

```
Trainer → Create/Edit Workout Form
   │
   ├─→ Input: <input type="file" name="image">
   │
   ├─→ POST /trainer/workouts (with image file)
   │
   └─→ Controller Processing:
       │
       ├─→ Validation:
       │   ├─ File is image (jpg, png, gif)
       │   ├─ Max size 2MB
       │   └─ Required or optional
       │
       ├─→ Storage::putFile():
       │   ├─ Upload to: storage/app/public/workouts/
       │   ├─ Generate unique filename
       │   └─ Return path: "workouts/abc123.jpg"
       │
       ├─→ Save to database:
       │   └─ workout.image = "workouts/abc123.jpg"
       │
       └─→ Display:
           └─ <img src="{{ asset('storage/' . $workout->image) }}">
               │
               └─ Public URL: public/storage/workouts/abc123.jpg
```

### Upload Avatar (Trainer/User Profile)

```
User → Edit Profile Form
   │
   ├─→ Input: <input type="file" name="avatar">
   │
   └─→ Controller:
       ├─ Upload to: storage/app/public/avatars/
       ├─ Save path to user.avatar
       └─ Display: asset('storage/' . user.avatar)
```

**File Terkait:**
- Controller: `app/Http/Controllers/Trainer/WorkoutController.php` (store, update methods)
- Controller: `app/Http/Controllers/Trainer/ProfileController.php`
- Storage Path: `storage/app/public/workouts/` & `storage/app/public/avatars/`
- Symlink: `php artisan storage:link` → `public/storage/`

---

## 📤 EXPORT EXCEL FLOW

```
User → /user/tracking → [Export to Excel] Button
   │
   └─→ GET /user/tracking/export
       │
       ├─→ TrackingController@export
       │   │
       │   ├─ Get user's workout progress:
       │   │   └─ UserWorkoutProgress::where('user_id', auth()->id())
       │   │                          ->with('workout')
       │   │                          ->orderBy('completed_at', 'desc')
       │   │                          ->get()
       │   │
       │   └─→ UserProgressExport.php:
       │       │
       │       ├─ Map data to Excel rows:
       │       │   ├─ Date: completed_at
       │       │   ├─ Workout: workout.title
       │       │   ├─ Category: workout.category.name
       │       │   ├─ Duration: workout.duration
       │       │   ├─ Calories: calories_burned
       │       │   └─ Notes: notes
       │       │
       │       └─→ Excel::download():
       │           ├─ Package: Maatwebsite/Excel
       │           ├─ Format: .xlsx
       │           ├─ Filename: trainify_progress_2024-01-20.xlsx
       │           └─ Browser: Auto download file
       │
END
```

**File Terkait:**
- Route: `routes/web.php` (line 84)
- Controller: `app/Http/Controllers/User/TrackingController.php` (export method)
- Export Class: `app/Exports/UserProgressExport.php`
- Package: `composer require maatwebsite/excel`

---

## 🔄 COMPLETE FLOW SUMMARY

### 1. Guest → Registration → Login
```
Landing (/) → /register → Fill form → POST /register 
→ Auto login → Redirect to dashboard (based on role)
```

### 2. Admin Daily Flow
```
/login → /admin/dashboard → View stats
→ /admin/workout-approval → Approve/Reject workouts
→ /admin/categories → CRUD categories (soft delete)
→ /admin/levels → CRUD levels (soft delete)
→ /admin/users → Manage users (soft delete, restore)
→ Logout
```

### 3. Trainer Daily Flow
```
/login → /trainer/dashboard → View stats
→ /trainer/workouts/create → Add workout + exercises + image
→ POST → Wait for admin approval (status: pending)
→ /trainer/workouts → View all workouts
→ /trainer/workouts/{id}/edit → Edit workout (reset to pending)
→ /trainer/profile → Update profile + avatar
→ Logout
```

### 4. User Daily Flow
```
/login → /user/dashboard → View stats & recommendations
→ /user/workouts → Browse workouts (filter)
→ /user/workouts/{id} → View detail
→ [Start Workout] → Complete modal → POST complete
→ /user/tracking → View progress history
→ [Export to Excel] → Download .xlsx file
→ Logout
```

---

## 📁 FILE MAPPING (Route → Controller → View)

| URL | Controller | Method | View | Purpose |
|-----|------------|--------|------|---------|
| `/` | - | - | - | Redirect to login or dashboard |
| `/login` | LoginController | showLoginForm | auth/login.blade.php | Login form |
| `POST /login` | LoginController | login | - | Process login |
| `/register` | RegisterController | showRegistrationForm | auth/register.blade.php | Register form |
| `POST /register` | RegisterController | register | - | Process registration |
| `POST /logout` | LoginController | logout | - | Logout user |
| `/admin/dashboard` | Admin\DashboardController | index | admin/dashboard.blade.php | Admin home |
| `/admin/categories` | Admin\CategoryController | index | admin/categories/index.blade.php | List categories |
| `/admin/categories/create` | Admin\CategoryController | create | admin/categories/create.blade.php | Create category form |
| `POST /admin/categories` | Admin\CategoryController | store | - | Save category |
| `/admin/categories/{id}/edit` | Admin\CategoryController | edit | admin/categories/edit.blade.php | Edit category form |
| `PUT /admin/categories/{id}` | Admin\CategoryController | update | - | Update category |
| `DELETE /admin/categories/{id}` | Admin\CategoryController | destroy | - | Soft delete category |
| `POST /admin/categories/{id}/restore` | Admin\CategoryController | restore | - | Restore deleted category |
| `DELETE /admin/categories/{id}/force-delete` | Admin\CategoryController | forceDelete | - | Permanent delete |
| `/admin/levels` | Admin\LevelController | index | admin/levels/index.blade.php | List levels |
| `/admin/levels/create` | Admin\LevelController | create | admin/levels/create.blade.php | Create level form |
| ... | ... | ... | ... | (Same CRUD as categories) |
| `/admin/workout-approval` | Admin\WorkoutApprovalController | index | admin/workout-approval.blade.php | Workout approval page |
| `POST /admin/workouts/{id}/approve` | Admin\WorkoutApprovalController | approve | - | Approve workout |
| `POST /admin/workouts/{id}/reject` | Admin\WorkoutApprovalController | reject | - | Reject workout |
| `/admin/users` | Admin\UserController | index | admin/users/index.blade.php | List users |
| `DELETE /admin/users/{id}` | Admin\UserController | destroy | - | Soft delete user |
| `POST /admin/users/{id}/restore` | Admin\UserController | restore | - | Restore user |
| `/trainer/dashboard` | Trainer\DashboardController | index | trainer/dashboard.blade.php | Trainer home |
| `/trainer/workouts` | Trainer\WorkoutController | index | trainer/workouts/index.blade.php | List my workouts |
| `/trainer/workouts/create` | Trainer\WorkoutController | create | trainer/workouts/create.blade.php | Create workout form |
| `POST /trainer/workouts` | Trainer\WorkoutController | store | - | Save workout + exercises |
| `/trainer/workouts/{id}/edit` | Trainer\WorkoutController | edit | trainer/workouts/edit.blade.php | Edit workout form |
| `PUT /trainer/workouts/{id}` | Trainer\WorkoutController | update | - | Update workout |
| `DELETE /trainer/workouts/{id}` | Trainer\WorkoutController | destroy | - | Delete workout |
| `/trainer/profile` | Trainer\ProfileController | edit | trainer/profile.blade.php | Edit profile form |
| `PUT /trainer/profile` | Trainer\ProfileController | update | - | Update profile + avatar |
| `PUT /trainer/profile/password` | Trainer\ProfileController | updatePassword | - | Change password |
| `/user/dashboard` | User\DashboardController | index | user/dashboard.blade.php | User home |
| `/user/workouts` | User\WorkoutController | index | user/workouts/index.blade.php | Browse workouts |
| `/user/workouts/{id}` | User\WorkoutController | show | user/workouts/show.blade.php | Workout detail |
| `POST /user/workouts/{id}/complete` | User\WorkoutController | complete | - | Complete workout |
| `/user/tracking` | User\TrackingController | index | user/tracking.blade.php | Progress tracking |
| `GET /user/tracking/export` | User\TrackingController | export | - | Export to Excel |

---

## 🎯 KEY FEATURES MAPPING

| Feature | Files Involved |
|---------|----------------|
| **Authentication Manual** | LoginController, RegisterController, User model, auth views |
| **Role-Based Middleware** | AdminMiddleware, TrainerMiddleware, UserMiddleware, bootstrap/app.php |
| **CRUD Master Data** | CategoryController, LevelController (with soft delete) |
| **CRUD dengan Relasi** | WorkoutController + ExerciseController (One-to-Many) |
| **Soft Delete** | All models (User, Category, Level, Workout) with SoftDeletes trait |
| **File Upload (Storage)** | WorkoutController (image), ProfileController (avatar) |
| **Export Excel** | TrackingController, UserProgressExport, Maatwebsite/Excel |
| **Many-to-Many Relasi** | User ↔ Workout (user_workout_progress pivot table) |
| **Auto Slug** | Category, Level, Workout models (observer/mutator) |
| **Workout Approval** | WorkoutApprovalController (pending → approved/rejected) |

---

## 🎓 UNTUK PRESENTASI

### Demo Flow Rekomendasi:

1. **Login sebagai Admin** → Show CRUD Categories (Create, Edit, Delete, Restore)
2. **Workout Approval** → Approve trainer's workout
3. **Login sebagai Trainer** → Create workout dengan multiple exercises + upload image
4. **Login sebagai User** → Browse workout → Complete workout → Export Excel
5. **Explain Code** → Show CategoryController (CRUD), Workout model (relasi), Middleware

### Highlight Points:
- ✅ 6 Migrations dengan foreign keys
- ✅ 6 Models dengan relationships & soft delete
- ✅ 12 Controllers terstruktur per role
- ✅ 3 Middleware untuk access control
- ✅ CRUD lengkap dengan soft delete & restore
- ✅ Relasi One-to-Many & Many-to-Many
- ✅ File upload dengan Laravel Storage
- ✅ Export Excel dengan Maatwebsite
- ✅ Authentication manual (tanpa Breeze)

---

**User Flow Documentation Complete! ✅**

File ini menjelaskan alur lengkap dari setiap fitur aplikasi Trainify untuk presentasi dan development reference.
