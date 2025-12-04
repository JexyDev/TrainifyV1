# 📊 DOKUMENTASI SISTEM - TRAINIFY

## ERD, BRD, dan User Manual untuk Rubrik Penilaian

---

## 1. 📐 ERD (Entity Relationship Diagram)

### Diagram Relasi

```
┌─────────────────────┐
│       USERS         │
├─────────────────────┤
│ id (PK)             │
│ name                │
│ email (UNIQUE)      │
│ password            │
│ role (ENUM)         │◄──────────┐
│ avatar              │           │
│ bio                 │           │
│ specialization      │           │
│ created_at          │           │
│ updated_at          │           │
│ deleted_at          │           │
└─────────────────────┘           │
         │                        │
         │ 1:M (Trainer)          │ M:M (User-Workout)
         ▼                        │
┌─────────────────────┐           │
│      WORKOUTS       │           │
├─────────────────────┤           │
│ id (PK)             │           │
│ trainer_id (FK)     │───────────┘
│ category_id (FK)    │─────┐
│ level_id (FK)       │─────┼──┐
│ title               │     │  │
│ slug (UNIQUE)       │     │  │
│ description         │     │  │
│ duration            │     │  │
│ image               │     │  │
│ status (ENUM)       │     │  │
│ created_at          │     │  │
│ updated_at          │     │  │
│ deleted_at          │     │  │
└─────────────────────┘     │  │
         │                  │  │
         │ 1:M              │  │
         ▼                  │  │
┌─────────────────────┐     │  │
│     EXERCISES       │     │  │
├─────────────────────┤     │  │
│ id (PK)             │     │  │
│ workout_id (FK)     │◄────┘  │
│ name                │        │
│ sets                │        │
│ reps                │        │
│ rest_seconds        │        │
│ order               │        │
│ created_at          │        │
│ updated_at          │        │
└─────────────────────┘        │
                               │
┌─────────────────────┐        │
│    CATEGORIES       │        │
├─────────────────────┤        │
│ id (PK)             │◄───────┘
│ name (UNIQUE)       │
│ slug (UNIQUE)       │
│ description         │
│ created_at          │
│ updated_at          │
│ deleted_at          │
└─────────────────────┘
         ▲
         │ M:1
         │
┌─────────────────────┐
│       LEVELS        │
├─────────────────────┤
│ id (PK)             │
│ name (UNIQUE)       │
│ slug (UNIQUE)       │
│ description         │
│ order               │
│ created_at          │
│ updated_at          │
│ deleted_at          │
└─────────────────────┘

┌──────────────────────────┐
│ USER_WORKOUT_PROGRESS    │
│      (Pivot Table)       │
├──────────────────────────┤
│ id (PK)                  │
│ user_id (FK)             │──┐
│ workout_id (FK)          │──┼── Many-to-Many Relationship
│ completed_at             │  │
│ calories_burned          │  │
│ notes                    │  │
│ created_at               │  │
│ updated_at               │  │
└──────────────────────────┘  │
         │                    │
         └────────────────────┘
```

### Penjelasan Relasi:

#### 1. **User → Workout (One-to-Many)**
- Satu Trainer bisa membuat banyak Workout
- Foreign Key: `workouts.trainer_id` → `users.id`

#### 2. **Workout → Exercise (One-to-Many)**
- Satu Workout memiliki banyak Exercise
- Foreign Key: `exercises.workout_id` → `workouts.id`
- Cascade Delete: Jika workout dihapus, exercises ikut terhapus

#### 3. **Category → Workout (One-to-Many)**
- Satu Category bisa digunakan banyak Workout
- Foreign Key: `workouts.category_id` → `categories.id`

#### 4. **Level → Workout (One-to-Many)**
- Satu Level bisa digunakan banyak Workout
- Foreign Key: `workouts.level_id` → `levels.id`

#### 5. **User ↔ Workout (Many-to-Many)**
- Satu User bisa complete banyak Workout
- Satu Workout bisa di-complete banyak User
- Pivot Table: `user_workout_progress`
- Foreign Keys: 
  - `user_workout_progress.user_id` → `users.id`
  - `user_workout_progress.workout_id` → `workouts.id`

---

## 2. 📝 BRD (Business Requirement Document)

### A. Executive Summary

**Nama Project:** Trainify - Workout Tracker Application  
**Tujuan:** Membangun aplikasi workout tracker berbasis web untuk memfasilitasi trainer dalam membuat program workout dan user dalam tracking progress latihan.  
**Platform:** Web Application (Laravel + Blade Template)  
**Target User:** Trainer, User, dan Admin

### B. Business Objectives

1. **Meningkatkan Efisiensi Trainer**
   - Mempermudah trainer dalam membuat dan mengelola workout
   - Sistem approval untuk quality control

2. **Meningkatkan Engagement User**
   - User dapat browse workout sesuai kebutuhan
   - Tracking progress dengan visualisasi data
   - Export laporan untuk monitoring personal

3. **Centralized Management**
   - Admin dapat mengelola master data (categories, levels)
   - Admin dapat approve/reject workout dari trainer
   - Monitoring aktivitas seluruh user

### C. Functional Requirements

#### 1. Authentication & Authorization
- **FR-1.1:** User dapat register dengan role (User/Trainer)
- **FR-1.2:** User dapat login dengan email & password
- **FR-1.3:** System melakukan redirect berdasarkan role setelah login
- **FR-1.4:** User dapat logout dari sistem

#### 2. Admin Module
- **FR-2.1:** Admin dapat melihat dashboard dengan statistik
- **FR-2.2:** Admin dapat CRUD Categories (Create, Read, Update, Delete)
- **FR-2.3:** Admin dapat CRUD Levels
- **FR-2.4:** Admin dapat soft delete, restore, dan force delete data
- **FR-2.5:** Admin dapat approve/reject workout dari trainer
- **FR-2.6:** Admin dapat melihat visualisasi data dengan grafik (Chart.js)

#### 3. Trainer Module
- **FR-3.1:** Trainer dapat membuat workout dengan multiple exercises
- **FR-3.2:** Trainer dapat upload gambar workout (Storage)
- **FR-3.3:** Trainer dapat edit dan delete workout milik sendiri
- **FR-3.4:** Trainer dapat melihat status approval workout (Pending, Approved, Rejected)
- **FR-3.5:** Trainer dapat edit profile dan upload avatar

#### 4. User Module
- **FR-4.1:** User dapat browse workout dengan filter (Category, Level, Duration)
- **FR-4.2:** User dapat melihat detail workout dan exercises
- **FR-4.3:** User dapat complete workout dengan input kalori & notes
- **FR-4.4:** User dapat melihat riwayat workout (tracking)
- **FR-4.5:** User dapat export progress ke Excel (.xlsx)
- **FR-4.6:** User dapat export progress ke PDF

#### 5. Data Management
- **FR-5.1:** System menggunakan Database Transaction untuk operasi krusial
- **FR-5.2:** System menggunakan Soft Delete untuk semua data
- **FR-5.3:** System menggunakan Eloquent Relationships untuk relasi antar tabel

### D. Non-Functional Requirements

#### 1. Performance
- **NFR-1.1:** Response time halaman < 2 detik
- **NFR-1.2:** Support concurrent users minimal 100 user
- **NFR-1.3:** Database query optimized dengan eager loading

#### 2. Security
- **NFR-2.1:** Password harus di-hash menggunakan bcrypt
- **NFR-2.2:** Implementasi CSRF protection
- **NFR-2.3:** Validasi input di semua form
- **NFR-2.4:** Middleware untuk role-based access control

#### 3. Usability
- **NFR-3.1:** Responsive design (desktop & mobile)
- **NFR-3.2:** User-friendly interface dengan Tailwind CSS
- **NFR-3.3:** Consistent design dengan color scheme biru-hijau toska
- **NFR-3.4:** Feedback message untuk setiap action (flash message)

#### 4. Reliability
- **NFR-4.1:** Database Transaction untuk data consistency
- **NFR-4.2:** Error handling dengan try-catch block
- **NFR-4.3:** Automatic rollback jika transaction gagal

### E. User Stories

#### Admin
- Sebagai Admin, saya ingin melihat statistik user dan workout di dashboard
- Sebagai Admin, saya ingin mengelola categories dan levels
- Sebagai Admin, saya ingin approve workout dari trainer untuk quality control
- Sebagai Admin, saya ingin melihat grafik distribusi workout per category

#### Trainer
- Sebagai Trainer, saya ingin membuat workout dengan multiple exercises
- Sebagai Trainer, saya ingin upload gambar untuk menarik user
- Sebagai Trainer, saya ingin melihat status approval workout saya
- Sebagai Trainer, saya ingin edit workout jika ada yang perlu diperbaiki

#### User
- Sebagai User, saya ingin browse workout berdasarkan category dan level
- Sebagai User, saya ingin complete workout dan mencatat progress
- Sebagai User, saya ingin melihat riwayat workout saya
- Sebagai User, saya ingin export laporan progress ke Excel/PDF

### F. System Constraints

1. **Technical Constraints:**
   - PHP Version >= 8.2
   - Laravel Framework 11
   - MySQL Database
   - Browser support: Chrome, Firefox, Safari, Edge (latest 2 versions)

2. **Business Constraints:**
   - Project timeline: [Sesuai jadwal sekolah]
   - Budget: Free (menggunakan open-source tools)
   - Deployment: Local server (XAMPP/Laragon)

### G. Success Criteria

1. ✅ Semua rubrik penilaian terpenuhi (100/100 poin)
2. ✅ Aplikasi dapat dijalankan tanpa error
3. ✅ Database terstruktur dengan baik (normalized)
4. ✅ Code clean dan readable
5. ✅ Dokumentasi lengkap dan jelas

---

## 3. 📖 USER MANUAL

### A. Instalasi

Lihat file [CARA_INSTALL.md](CARA_INSTALL.md) untuk panduan lengkap.

### B. Panduan Penggunaan

#### 🔐 ADMIN

**1. Login**
```
URL: http://localhost:8000/login
Email: admin@trainify.com
Password: password
```

**2. Dashboard**
- Lihat statistik total users, trainers, workouts
- Lihat grafik "Workouts by Category" (Doughnut Chart)
- Lihat grafik "Workout Completions" (Line Chart)
- Lihat daftar recent workouts

**3. Manage Categories**
```
Sidebar → Categories
- Create: Klik "Add Category" → Isi form → Submit
- Edit: Klik icon pensil → Update → Submit
- Delete: Klik icon trash → Confirm (Soft Delete)
- Restore: Klik "Show Deleted" → Klik "Restore"
- Force Delete: Klik "Show Deleted" → Klik "Delete Permanent"
```

**4. Manage Levels**
```
Sidebar → Levels
(Sama seperti Categories)
```

**5. Workout Approval**
```
Sidebar → Workout Approval
- Lihat pending workouts dari trainer
- Klik "Approve" untuk menyetujui
- Klik "Reject" untuk menolak
```

**6. Manage Users**
```
Sidebar → Manage Users
- Lihat daftar semua users
- Soft delete user jika diperlukan
- Restore deleted users
```

---

#### 💪 TRAINER

**1. Login**
```
URL: http://localhost:8000/login
Email: trainer@trainify.com
Password: password
```

**2. Dashboard**
- Lihat statistik workout pribadi
- Lihat pending, approved, rejected workouts
- Quick actions: Create Workout, View Profile

**3. Create Workout**
```
Sidebar → Workouts → Add Workout
1. Isi informasi workout:
   - Title
   - Description
   - Category (pilih dari dropdown)
   - Level (pilih dari dropdown)
   - Duration (menit)
   - Upload Image (optional)

2. Tambah exercises:
   - Klik "Add Exercise"
   - Isi nama, sets, reps, rest time
   - Klik "Add Exercise" lagi untuk menambah
   - Klik "Remove" untuk menghapus

3. Submit
   - Status akan "Pending" menunggu approval admin
```

**4. Edit Workout**
```
Sidebar → Workouts → Klik icon pensil
- Edit informasi workout
- Edit exercises
- Submit → Status kembali ke "Pending"
```

**5. Delete Workout**
```
Sidebar → Workouts → Klik icon trash
- Workout akan soft deleted
```

**6. Edit Profile**
```
Sidebar → Profile
- Update nama, bio, specialization
- Upload avatar
- Update password
```

---

#### 🏃 USER

**1. Login**
```
URL: http://localhost:8000/login
Email: user@trainify.com
Password: password
```

**2. Dashboard**
- Lihat workout progress statistics
- Lihat recent completed workouts
- Quick access ke Browse Workouts

**3. Browse Workouts**
```
Sidebar → Workouts
- Filter by Category (dropdown)
- Filter by Level (dropdown)
- Filter by Duration (Short/Medium/Long)
- Klik card workout untuk detail
```

**4. View Workout Detail**
```
Klik workout → Detail page
- Lihat informasi workout lengkap
- Lihat list exercises (nama, sets, reps, rest)
- Klik "Complete Workout" jika sudah selesai
```

**5. Complete Workout**
```
Detail Workout → Complete Workout
1. Modal akan muncul
2. Isi:
   - Calories Burned (optional)
   - Notes (optional)
3. Submit
4. Data tersimpan di tracking
```

**6. Tracking Progress**
```
Sidebar → Tracking
- Lihat weekly stats (bar chart)
- Lihat workout history (table)
- Pagination jika data banyak
```

**7. Export to Excel**
```
Sidebar → Tracking → Export Excel
- File .xlsx akan otomatis terdownload
- Nama file: my-workout-progress.xlsx
- Berisi: Date, Workout, Category, Duration, Calories, Notes
```

**8. Export to PDF**
```
Sidebar → Tracking → Export PDF
- File .pdf akan otomatis terdownload
- Nama file: my-workout-progress.pdf
- Berisi:
  - User info
  - Summary stats
  - Workout history (lengkap)
  - Design professional dengan color scheme Trainify
```

---

### C. FAQ (Frequently Asked Questions)

**Q: Bagaimana cara register?**  
A: Klik "Register" di halaman login → Isi form → Pilih role (User/Trainer) → Submit

**Q: Lupa password?**  
A: Fitur reset password belum diimplementasikan. Hubungi admin atau reset manual di database.

**Q: Workout saya statusnya "Pending", kenapa?**  
A: Workout dari trainer harus di-approve oleh admin terlebih dahulu untuk quality control.

**Q: Bisa upload gambar format apa?**  
A: Format yang didukung: JPG, JPEG, PNG. Maksimal ukuran 2MB.

**Q: Export Excel/PDF berisi data apa?**  
A: Berisi riwayat workout yang sudah Anda complete beserta tanggal, kalori, dan notes.

**Q: Bisa delete workout yang sudah di-approve?**  
A: Trainer bisa delete workout miliknya. Data akan soft deleted (masih bisa di-restore).

---

### D. Technical Support

**Jika mengalami error:**
1. Cek file log di `storage/logs/laravel.log`
2. Clear cache: `php artisan cache:clear`
3. Cek dokumentasi: README.md, CARA_INSTALL.md
4. Hubungi pembimbing/guru

**System Requirements:**
- PHP >= 8.2
- MySQL >= 8.0
- Browser modern (Chrome, Firefox, Safari, Edge)
- Koneksi internet (untuk CDN Chart.js & Tailwind CSS)

---

## 4. 📸 Screenshot (Optional)

### Admin Dashboard
- [Screenshot dashboard dengan grafik Chart.js]

### Trainer Create Workout
- [Screenshot form create workout dengan multiple exercises]

### User Complete Workout
- [Screenshot modal complete workout]

### Export PDF
- [Screenshot hasil PDF yang di-generate]

---

## 5. 📞 Contact Information

**Developer:** [Nama Siswa]  
**Kelas:** [Kelas Anda]  
**Sekolah:** SMK Wikrama Bogor  
**Email:** [Email Anda]  

**Pembimbing:** [Nama Guru]  
**Mata Pelajaran:** Pemrograman Web  

---

<div align="center">

**TRAINIFY - WORKOUT TRACKER APPLICATION**

Dokumentasi ini dibuat untuk memenuhi rubrik penilaian:  
**"Dokumentasi Sistem dan User Manual (5 poin)"**

© 2024 SMK Wikrama Bogor

</div>
