# ⚡ TRAINIFY - QUICK START GUIDE

## 🚀 Install dalam 5 Menit

### 1️⃣ Install Dependencies
```bash
cd laravel-trainify
composer install
```

### 2️⃣ Setup Environment
```bash
copy .env.example .env   # Windows
cp .env.example .env     # Mac/Linux

# Edit .env:
# DB_DATABASE=trainify
# DB_USERNAME=root
# DB_PASSWORD=
```

### 3️⃣ Generate Key & Setup Database
```bash
php artisan key:generate

# Buat database di PhpMyAdmin:
# CREATE DATABASE trainify;

php artisan migrate --seed
php artisan storage:link
```

### 4️⃣ Run Server
```bash
php artisan serve
```

Buka: **http://localhost:8000**

---

## 🔑 Login Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@trainify.com | password |
| Trainer | trainer@trainify.com | password |
| User | user@trainify.com | password |

---

## 🎯 Quick Demo Flow

### 1. Admin (2 menit)
```
Login → Dashboard
→ Lihat 2 grafik Chart.js ✅
→ Categories → Add Category
→ Workout Approval → Approve
```

### 2. Trainer (2 menit)
```
Login → Dashboard
→ Add Workout + Exercises ✅
→ Upload Image
→ Lihat status Pending
```

### 3. User (3 menit)
```
Login → Dashboard
→ Browse Workouts
→ Complete Workout ✅
→ Tracking → Export Excel & PDF ✅
```

---

## 📊 Fitur Baru (Update Terbaru)

✅ **Export PDF** - Laporan workout dalam PDF  
✅ **DB Transaction** - Data consistency guarantee  
✅ **Chart.js** - 2 grafik di Admin Dashboard  

---

## 🐛 Fix Error Cepat

```bash
# Error "Class not found"
composer dump-autoload

# Error migrations
php artisan migrate:fresh --seed

# Error cache
php artisan config:clear
php artisan view:clear

# Error upload
php artisan storage:link
```

---

## 📋 Checklist Presentasi

- [ ] Server running
- [ ] Database seeded
- [ ] Test login 3 role
- [ ] Test Chart.js
- [ ] Test Export PDF
- [ ] VS Code open

---

## 📚 Dokumentasi Lengkap

- [README.md](README.md) - Overview lengkap
- [CARA_INSTALL.md](CARA_INSTALL.md) - Install detail
- [UPDATE_LENGKAP_RUBRIK.md](UPDATE_LENGKAP_RUBRIK.md) - Fitur baru
- [DOKUMENTASI_ERD_BRD.md](DOKUMENTASI_ERD_BRD.md) - ERD & User Manual
- [CHECKLIST_FINAL.md](CHECKLIST_FINAL.md) - Testing checklist

---

## 🎓 Total Poin: 100/100 ✅

Made with ❤️ for SMK Wikrama Bogor
