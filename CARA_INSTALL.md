# 🚀 CARA INSTALL TRAINIFY - Step by Step

## ⚠️ PENTING: UPDATE TERBARU

Project sudah diupdate dengan fitur:
- ✅ Export PDF (DomPDF)
- ✅ Transaksi Database (DB::transaction)
- ✅ Chart.js untuk grafik dashboard

## Langkah 1: Persiapan

Pastikan sudah install:
- ✅ PHP 8.2 atau lebih tinggi
- ✅ Composer
- ✅ MySQL
- ✅ Node.js & NPM (optional untuk Vite)

Cek versi dengan command:
```bash
php --version
composer --version
mysql --version
```

## Langkah 2: Extract & Copy Project

1. Extract folder `laravel-trainify` ke folder htdocs (jika pakai XAMPP) atau tempat lain
2. Buka terminal/command prompt
3. Masuk ke folder project:
```bash
cd C:\xampp\htdocs\laravel-trainify
```
(Sesuaikan path dengan lokasi folder Anda)

## Langkah 3: Install Dependencies

Install PHP dependencies (termasuk DomPDF untuk export PDF):
```bash
composer install
```

Jika error, coba:
```bash
composer update
```

Install JavaScript dependencies (optional):
```bash
npm install
```

## Langkah 4: Setup Environment

Copy file `.env.example` jadi `.env`:

**Windows (CMD):**
```bash
copy .env.example .env
```

**Mac/Linux:**
```bash
cp .env.example .env
```

Buka file `.env` dengan text editor (Notepad++, VSCode, dll) dan edit:

```env
APP_NAME=Trainify
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=trainify
DB_USERNAME=root
DB_PASSWORD=
```

*Catatan: Sesuaikan DB_USERNAME dan DB_PASSWORD dengan setting MySQL Anda*

## Langkah 5: Generate Key

```bash
php artisan key:generate
```

## Langkah 6: Buat Database

1. Buka phpMyAdmin (http://localhost/phpmyadmin)
2. Klik tab "SQL"
3. Jalankan query:
```sql
CREATE DATABASE trainify;
```
4. Atau buat manual lewat interface

## Langkah 7: Run Migration & Seeder

```bash
php artisan migrate --seed
```

Command ini akan:
- Membuat semua tabel (users, categories, levels, workouts, dll)
- Mengisi data dummy (admin, trainer, user, categories, levels, workouts)

## Langkah 8: Storage Symlink

```bash
php artisan storage:link
```

Command ini untuk upload file (gambar workout, avatar, dll)

## Langkah 9: Compile Assets (Optional)

Untuk development:
```bash
npm run dev
```

Atau untuk production (lebih cepat):
```bash
npm run build
```

*Catatan: Jika pakai `npm run dev`, biarkan terminal terbuka*

## Langkah 10: Jalankan Server

Buka terminal, jalankan:
```bash
php artisan serve
```

Buka browser, akses: **http://localhost:8000**

**CATATAN:** Tidak perlu menjalankan `npm run dev` karena project ini menggunakan Tailwind CSS via CDN di Blade template.

## ✅ Login

### Admin
- Email: `admin@trainify.com`
- Password: `password`

### Trainer
- Email: `trainer@trainify.com`
- Password: `password`

### User
- Email: `user@trainify.com`
- Password: `password`

## 🔧 Troubleshooting

### Error \"Class 'Barryvdh\DomPDF\Facade\Pdf' not found\"
```bash
composer require barryvdh/laravel-dompdf
php artisan config:clear
```

### Error \"Maatwebsite\Excel\" not found
```bash
composer require maatwebsite/excel
php artisan config:clear
```

### Error \"Class not found\"
```bash
composer dump-autoload
```

### Error migrations
```bash
php artisan migrate:fresh --seed
```

### Error cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### Error permission (Linux/Mac)
```bash
chmod -R 775 storage bootstrap/cache
```

### Port 8000 sudah terpakai
```bash
php artisan serve --port=8001
```

### Error "No application encryption key has been specified"
```bash
php artisan key:generate
```

## 📝 Tips

1. **Jika edit file .env:**
   ```bash
   php artisan config:clear
   ```

2. **Jika error saat upload file:**
   ```bash
   php artisan storage:link
   ```

3. **Jika error database:**
   - Pastikan MySQL sudah running
   - Cek DB_DATABASE, DB_USERNAME, DB_PASSWORD di .env
   - Buat database manual: `CREATE DATABASE trainify;`

## 🎯 Testing Fitur Baru

### 1. Test Export PDF
```
1. Login sebagai User (user@trainify.com / password)
2. Complete beberapa workout
3. Klik menu "Tracking"
4. Klik tombol "Export PDF" (warna merah)
5. File PDF akan otomatis terdownload
```

### 2. Test Chart.js
```
1. Login sebagai Admin (admin@trainify.com / password)
2. Lihat dashboard
3. Scroll ke bawah, akan ada 2 grafik:
   - Doughnut chart "Workouts by Category"
   - Line chart "Workout Completions"
```

### 3. Test Transaksi Database
```
1. Login sebagai Trainer
2. Create workout baru dengan multiple exercises
3. Submit → Jika berhasil, workout + exercises tersimpan
4. Jika ada error, semua akan di-rollback (tidak ada data sebagian)
```

## 🎓 Untuk Presentasi

### Demo Flow Lengkap:

1. **Login Admin** → Tunjukkan:
   - Dashboard dengan 2 grafik Chart.js ✅
   - CRUD Categories (Create, Edit, Delete, Restore)
   - Workout Approval

2. **Login Trainer** → Tunjukkan:
   - Create workout dengan relasi exercises (DB Transaction) ✅
   - Upload gambar (Storage)
   - Edit profile

3. **Login User** → Tunjukkan:
   - Browse workouts dengan filter
   - Complete workout (DB Transaction) ✅
   - View tracking
   - Export Excel ✅
   - Export PDF ✅ (BARU!)

### Explain Code:
```
Buka VS Code → Tunjukkan:
1. WorkoutController@store → DB::transaction()
2. TrackingController@exportPdf → DomPDF
3. AdminDashboardController → Chart.js data
4. Migration files → Relasi foreign keys
5. Model → Soft deletes & relationships
```

---

## 📊 Checklist Sebelum Presentasi

- [ ] Server running (`php artisan serve`)
- [ ] Database sudah di-migrate dan di-seed
- [ ] Test login 3 role (Admin, Trainer, User)
- [ ] Test CRUD categories
- [ ] Test create workout dengan exercises
- [ ] Test upload image
- [ ] Test export Excel
- [ ] Test export PDF ✅ (BARU!)
- [ ] Test Chart.js di dashboard ✅ (BARU!)
- [ ] Siapkan VS Code untuk explain code

---

**Good Luck untuk Presentasi! 🚀**

**Total Poin Rubrik: 100/100 ✅**

**Jika ada error, cek file UPDATE_LENGKAP_RUBRIK.md untuk troubleshooting**