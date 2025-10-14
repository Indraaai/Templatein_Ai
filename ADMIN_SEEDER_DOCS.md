# 👤 Admin Seeder Documentation

## Overview

Seeder untuk membuat akun administrator default agar admin tidak perlu melakukan registrasi manual.

---

## File Location

📁 `database/seeders/AdminSeeder.php`

---

## Default Admin Credentials

| Field              | Value                      |
| ------------------ | -------------------------- |
| **Name**           | Administrator              |
| **Email**          | admin@template.test        |
| **Password**       | admin123                   |
| **Role**           | admin                      |
| **Email Verified** | Yes (verified at creation) |

---

## Usage

### 1. Run Admin Seeder Only

```powershell
php artisan db:seed --class=AdminSeeder
```

**Output:**

```
✅ Admin account created successfully!
📧 Email: admin@template.test
🔑 Password: admin123
```

### 2. Run All Seeders (including Admin)

```powershell
php artisan db:seed
```

### 3. Fresh Migration with Seeders

```powershell
php artisan migrate:fresh --seed
```

---

## Features

### ✅ Duplicate Prevention

Seeder akan mengecek apakah email admin sudah ada di database sebelum membuat akun baru.

**Jika admin sudah ada:**

```
⚠️  Admin account already exists!
```

### ✅ Automatic Email Verification

Akun admin otomatis terverifikasi saat dibuat (`email_verified_at` sudah terisi).

### ✅ Secure Password

Password di-hash menggunakan `Hash::make()` untuk keamanan.

---

## Testing Login

### Via API (Postman/cURL)

```bash
POST /api/login
Content-Type: application/json

{
  "email": "admin@template.test",
  "password": "admin123"
}
```

### Via Web Browser

```
URL: http://localhost/login
Email: admin@template.test
Password: admin123
```

---

## Customization

### Change Default Credentials

Edit file: `database/seeders/AdminSeeder.php`

```php
User::create([
    'name' => 'Your Admin Name',           // Ubah nama
    'email' => 'youremail@domain.com',     // Ubah email
    'password' => Hash::make('yourpassword'), // Ubah password
    'role' => 'admin',
    'email_verified_at' => now(),
]);
```

### Create Multiple Admins

```php
public function run(): void
{
    $admins = [
        [
            'name' => 'Super Admin',
            'email' => 'superadmin@template.test',
            'password' => Hash::make('super123'),
        ],
        [
            'name' => 'Admin 1',
            'email' => 'admin1@template.test',
            'password' => Hash::make('admin123'),
        ],
    ];

    foreach ($admins as $adminData) {
        if (!User::where('email', $adminData['email'])->exists()) {
            User::create([
                ...$adminData,
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
        }
    }
}
```

---

## Security Notes

### ⚠️ Production Environment

**PENTING:** Untuk production, WAJIB ganti password default!

```powershell
# Setelah login pertama kali, ubah password via:
# 1. Profile Settings
# 2. Password Reset
# 3. Manual via Tinker:

php artisan tinker
>>> $admin = User::where('email', 'admin@template.test')->first();
>>> $admin->password = Hash::make('new-secure-password');
>>> $admin->save();
```

### 🔒 Best Practices

1. **Jangan commit** credentials ke repository
2. **Gunakan .env** untuk credentials production
3. **Enable 2FA** untuk akun admin (jika ada fitur)
4. **Rotate password** secara berkala
5. **Monitor login activity** akun admin

---

## Environment-Specific Seeding

### Development Only

```php
public function run(): void
{
    if (app()->environment('local', 'development')) {
        User::create([
            'name' => 'Dev Admin',
            'email' => 'admin@template.test',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
    }
}
```

### Use .env Variables

```php
User::create([
    'name' => env('ADMIN_NAME', 'Administrator'),
    'email' => env('ADMIN_EMAIL', 'admin@template.test'),
    'password' => Hash::make(env('ADMIN_PASSWORD', 'admin123')),
    'role' => 'admin',
    'email_verified_at' => now(),
]);
```

**.env:**

```env
ADMIN_NAME="Your Admin Name"
ADMIN_EMAIL="admin@yourdomain.com"
ADMIN_PASSWORD="strong-password-here"
```

---

## Troubleshooting

### Error: "Field 'role' doesn't have a default value"

**Solution:** Pastikan kolom `role` ada di migration `users` table:

```php
$table->string('role')->default('mahasiswa');
```

### Error: "Integrity constraint violation: Duplicate entry"

**Solution:** Admin sudah ada di database. Hapus atau skip:

```powershell
# Hapus admin lama
php artisan tinker
>>> User::where('email', 'admin@template.test')->delete();

# Atau jalankan migrate fresh
php artisan migrate:fresh --seed
```

### Password Tidak Cocok

**Pastikan:**

1. Password menggunakan `Hash::make()`
2. Login menggunakan password plain (bukan hashed)
3. Check capslock/typo

---

## Related Files

-   📄 `app/Models/User.php` - User model
-   📄 `database/migrations/*_create_users_table.php` - Users migration
-   📄 `database/seeders/DatabaseSeeder.php` - Main seeder

---

## Next Steps

1. ✅ Admin seeder created
2. ⏭️ Create Faculty & Program Study seeders
3. ⏭️ Create sample template seeders
4. ⏭️ Create student test accounts

---

**Created:** October 14, 2025  
**Author:** System  
**Version:** 1.0.0  
**Status:** ✅ Active
