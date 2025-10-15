# ✅ Quick Start Guide - Breeze Authentication

## 🎯 Sistem Sudah Siap!

Authentication system dengan Laravel Breeze telah berhasil diimplementasikan dengan customization untuk:

-   ✅ Role-based access (Admin & Mahasiswa)
-   ✅ Faculty & Program Study selection
-   ✅ Separate dashboards

---

## 🚀 Cara Testing

### 1. Start Development Server

```bash
php artisan serve
```

### 2. Start Vite (Optional - untuk compile assets)

Buka terminal baru:

```bash
npm run dev
```

### 3. Buka Browser

```
http://localhost:8000
```

---

## 🔐 Login Credentials

### Admin Account

```
Email: admin@template.test
Password: admin123
```

Setelah login sebagai admin, akan redirect ke:

```
http://localhost:8000/admin/dashboard
```

---

## 📝 Test Registration (Mahasiswa)

### 1. Buka halaman register

```
http://localhost:8000/register
```

### 2. Isi form:

-   **Name:** Budi Santoso
-   **Email:** budi@student.test
-   **Fakultas:** Pilih "Fakultas Teknik"
-   **Program Studi:** Otomatis muncul pilihan (via AJAX):
    -   Teknik Informatika
    -   Sistem Informasi
    -   Teknik Elektro
    -   Teknik Sipil
-   **Password:** student123
-   **Confirm Password:** student123

### 3. Submit

Setelah berhasil registrasi, akan:

-   ✅ User ter-create dengan role='mahasiswa'
-   ✅ Auto login
-   ✅ Redirect ke `http://localhost:8000/student/dashboard`

---

## 📊 Dashboard Features

### Admin Dashboard

```
URL: /admin/dashboard
```

**Features:**

-   ✅ Stats cards: Total Templates, Active Templates, Total Students, Total Checks
-   ✅ Quick action buttons (placeholder untuk next phase)
-   ✅ Dark mode support

### Student Dashboard

```
URL: /student/dashboard
```

**Features:**

-   ✅ User info: Fakultas & Program Studi
-   ✅ Template grid (filtered by faculty & prodi)
-   ✅ Recent document checks table
-   ✅ Empty state (karena belum ada template)
-   ✅ Dark mode support

---

## 🧪 Test Checklist

### Registration

-   [ ] Buka /register
-   [ ] Pilih fakultas → dropdown prodi otomatis load via AJAX
-   [ ] Submit form → user ter-create dengan role='mahasiswa'
-   [ ] Redirect ke /student/dashboard

### Admin Login

-   [ ] Buka /login
-   [ ] Login dengan admin@template.test / admin123
-   [ ] Redirect ke /admin/dashboard
-   [ ] Lihat stats cards

### Student Login

-   [ ] Buka /login
-   [ ] Login dengan akun mahasiswa yang baru dibuat
-   [ ] Redirect ke /student/dashboard
-   [ ] Lihat info fakultas & prodi

### Middleware Protection

-   [ ] Login sebagai student
-   [ ] Coba akses /admin/dashboard → Harus 403 Forbidden
-   [ ] Login sebagai admin
-   [ ] Coba akses /student/dashboard → Harus 403 Forbidden

### AJAX Functionality

-   [ ] Buka /register
-   [ ] Pilih fakultas → dropdown prodi harus ter-load otomatis
-   [ ] Ubah fakultas → dropdown prodi harus update sesuai fakultas

---

## 📋 Seeded Data

### Faculties (5)

1. Fakultas Teknik
2. Fakultas Ekonomi dan Bisnis
3. Fakultas MIPA
4. Fakultas Ilmu Sosial dan Politik
5. Fakultas Hukum

### Program Studies (15)

-   **Teknik:** Teknik Informatika, Sistem Informasi, Teknik Elektro, Teknik Sipil
-   **Ekonomi:** Manajemen, Akuntansi, Ekonomi Pembangunan
-   **MIPA:** Matematika, Fisika, Kimia, Biologi
-   **Sosial Politik:** Ilmu Komunikasi, Ilmu Pemerintahan, Sosiologi
-   **Hukum:** Ilmu Hukum

### Admin Account (1)

-   Email: admin@template.test
-   Password: admin123
-   Role: admin

---

## 🔧 Troubleshooting

### Issue: AJAX tidak load program studies

**Check:**

1. Buka browser console (F12)
2. Lihat apakah ada error saat fetch API
3. Pastikan route `/api/program-studies/{facultyId}` accessible

### Issue: 403 Forbidden saat akses dashboard

**Check:**

1. Pastikan sudah login
2. Check role user (admin atau mahasiswa)
3. Pastikan middleware 'role' sudah registered di `bootstrap/app.php`

### Issue: Assets tidak load (CSS/JS)

**Solution:**

```bash
# Compile assets
npm run build

# Or run dev server
npm run dev
```

### Issue: Dark mode tidak muncul

**Solution:**
Dark mode sudah built-in dari Breeze, toggle ada di navbar (jika sudah login)

---

## 📁 Important Files

### Controllers

```
app/Http/Controllers/Auth/RegisteredUserController.php
app/Http/Controllers/Auth/AuthenticatedSessionController.php
app/Http/Controllers/Admin/DashboardController.php
app/Http/Controllers/Student/DashboardController.php
```

### Middleware

```
app/Http/Middleware/CheckRole.php
bootstrap/app.php (middleware registration)
```

### Routes

```
routes/web.php (admin/student routes + API)
```

### Views

```
resources/views/auth/register.blade.php
resources/views/admin/dashboard.blade.php
resources/views/student/dashboard.blade.php
```

---

## 🎯 Next Steps

### Setelah Testing Berhasil:

#### Phase 2: Template Management

-   [ ] Create Template CRUD for admin
-   [ ] Upload template files (.docx)
-   [ ] Assign faculty & prodi to templates
-   [ ] Toggle active/inactive

#### Phase 3: Template Download

-   [ ] Student can browse templates
-   [ ] Download template functionality
-   [ ] Track download history

#### Phase 4: Document Check

-   [ ] Student upload document
-   [ ] OpenAI GPT-4 integration
-   [ ] Display check results

---

## 📚 Documentation

Full documentation tersedia di:

```
BREEZE_AUTH_IMPLEMENTATION.md - Complete implementation guide
ROADMAP.md - 13-phase development plan
DATABASE_MIGRATIONS_SUMMARY.md - Database schema
ADMIN_SEEDER_DOCS.md - Admin seeder info
CREDENTIALS.md - Login credentials
```

---

## ✅ Status

**Authentication System:** ✅ COMPLETE  
**Database:** ✅ Migrated & Seeded  
**Routes:** ✅ 25 routes registered  
**Views:** ✅ Admin & Student dashboards ready  
**Testing:** ⏳ Ready for manual testing

---

**Start testing now:**

```bash
php artisan serve
# Visit: http://localhost:8000
```

Good luck! 🚀
