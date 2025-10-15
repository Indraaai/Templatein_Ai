# 🔑 Login Credentials - Quick Reference

## 👤 Admin Account

### Default Admin

```
Email    : admin@template.test
Password : admin123
Role     : admin
Status   : ✅ Email Verified
```

**Login URL:**

-   Web: `http://localhost:8000/login`
-   After Login: `http://localhost:8000/admin/dashboard`

**Created By:** AdminSeeder  
**File:** `database/seeders/AdminSeeder.php`

---

## 👨‍🎓 Student Registration

### How to Create Student Account

1. **Visit Registration Page:**

    ```
    http://localhost:8000/register
    ```

2. **Fill Form:**

    - Name: Your Name
    - Email: your.email@student.test
    - Fakultas: Select from dropdown (5 options)
    - Program Studi: Auto-loaded via AJAX based on faculty
    - Password: Min 8 characters
    - Confirm Password: Same as password

3. **After Registration:**
    - Role automatically set to `'mahasiswa'`
    - Auto login
    - Redirect to: `http://localhost:8000/student/dashboard`

### Example Student Account

```
Name     : Budi Santoso
Email    : budi@student.test
Password : student123
Faculty  : Fakultas Teknik
Prodi    : Teknik Informatika
Role     : mahasiswa
```

---

## 🏫 Available Faculties & Program Studies

### Fakultas Teknik (ID: 1)

-   Teknik Informatika
-   Sistem Informasi
-   Teknik Elektro
-   Teknik Sipil

### Fakultas Ekonomi dan Bisnis (ID: 2)

-   Manajemen
-   Akuntansi
-   Ekonomi Pembangunan

### Fakultas MIPA (ID: 3)

-   Matematika
-   Fisika
-   Kimia
-   Biologi

### Fakultas Ilmu Sosial dan Politik (ID: 4)

-   Ilmu Komunikasi
-   Ilmu Pemerintahan
-   Sosiologi

### Fakultas Hukum (ID: 5)

-   Ilmu Hukum

---

## 🔐 Security Reminders

### ⚠️ PRODUCTION CHECKLIST

-   [ ] Ganti password default `admin123`
-   [ ] Update email ke domain production
-   [ ] Enable two-factor authentication (jika tersedia)
-   [ ] Monitor login activity
-   [ ] Rotate password secara berkala
-   [ ] Gunakan strong password (min 12 karakter, kombinasi huruf, angka, simbol)

### 🔒 Recommended Strong Password Format

```
Example: Adm!n2025@TempLate#Sys
- Minimal 12 karakter
- Huruf besar & kecil
- Angka
- Simbol khusus
```

```
# Teknik Informatika
Email    : student.ti@template.test
Password : student123
Faculty  : Fakultas Teknik
Prodi    : Teknik Informatika

# Manajemen
Email    : student.mgt@template.test
Password : student123
Faculty  : Fakultas Ekonomi
Prodi    : Manajemen
```

---

## 📋 Commands

### Create New Admin

```powershell
php artisan db:seed --class=AdminSeeder
```

### Reset Admin Password (via Tinker)

```powershell
php artisan tinker
>>> $admin = User::where('email', 'admin@template.test')->first();
>>> $admin->password = Hash::make('new-password-here');
>>> $admin->save();
>>> exit
```

### Check Admin Account

```powershell
php artisan tinker --execute="echo User::where('email', 'admin@template.test')->first();"
```

### Delete Admin Account

```powershell
php artisan tinker
>>> User::where('email', 'admin@template.test')->delete();
>>> exit
```

---

## 🔧 Troubleshooting

### Cannot Login - Password Mismatch

```powershell
# Reset password
php artisan tinker
>>> $admin = User::where('email', 'admin@template.test')->first();
>>> $admin->password = Hash::make('admin123');
>>> $admin->save();
```

### Admin Account Not Found

```powershell
# Run seeder again
php artisan db:seed --class=AdminSeeder
```

### Multiple Admin Accounts

```powershell
# Check all admins
php artisan tinker --execute="echo User::where('role', 'admin')->get(['id', 'email', 'name']);"
```

---

## 📝 Notes

-   **Development:** Gunakan credentials ini untuk development
-   **Staging:** Update dengan credentials staging
-   **Production:** WAJIB ganti dengan credentials secure

---

**Last Updated:** October 14, 2025
**Environment:** Development
**Status:** ✅ Active
