# 📄 Template Management System with AI Document Checker

Sistem manajemen template dokumen akademik berbasis web yang memungkinkan admin membuat template dokumen dengan auto-generate file .docx, mahasiswa dapat download template sesuai fakultas/prodi mereka, dan mengecek kesesuaian struktur dokumen mereka menggunakan AI.

---

## 🌟 Fitur Utama

### 👨‍💼 Fitur Admin

-   ✅ **Manajemen Data Master** - Kelola Fakultas, Program Studi, dan Mahasiswa
-   ✅ **Template Builder** - Buat template dengan Visual Builder atau JSON Editor
-   ✅ **Auto-Generate .docx** - Generate file Word otomatis dari aturan template
-   ✅ **Live Preview** - Preview template secara real-time
-   ✅ **Template Management** - Aktifkan/non-aktifkan, edit, dan regenerate template
-   ✅ **Dashboard Analytics** - Lihat statistik penggunaan template

### 👨‍🎓 Fitur Mahasiswa

-   ✅ **Download Template** - Download template sesuai fakultas/prodi
-   ✅ **Document Checker** - Upload dan cek dokumen dengan AI
-   ✅ **Compliance Report** - Lihat skor kepatuhan dan saran perbaikan
-   ✅ **History** - Riwayat pengecekan dokumen

---

## 🚀 Quick Start

### Prerequisites

-   PHP >= 8.2
-   Composer
-   Node.js & NPM
-   MySQL >= 8.0
-   Git

### 1. Clone Repository

```bash
git clone https://github.com/Indraaai/Templatein_Ai.git
cd Templatein_Ai
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Setup Environment

```bash
# Copy .env.example ke .env
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Database

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=template_in
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Run Migrations & Seeders

```bash
# Migrate database dan seed data
php artisan migrate:fresh --seed
```

### 6. Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### 7. Run Development Server

```bash
# Terminal 1 - Laravel Server
php artisan serve

# Terminal 2 - Vite Dev Server (optional untuk development)
npm run dev
```

Aplikasi akan berjalan di: **http://localhost:8000**

---

## 👤 Default Accounts

### Admin Account

```
📧 Email: admin@template.test
🔑 Password: admin123
```

### Student Accounts (Test)

```
📧 Email: student1@example.com - student5@example.com
🔑 Password: password
```

**⚠️ PENTING:** Ganti semua password default setelah login pertama kali untuk keamanan!

---

## 📋 Dokumentasi Lengkap

### 🎯 Getting Started

-   📘 [QUICK_START.md](QUICK_START.md) - Panduan cepat memulai
-   📗 [SYSTEM_DESIGN_DFD_ERD.md](SYSTEM_DESIGN_DFD_ERD.md) - DFD & ERD Sistem

### � Feature Documentation

-   � [ACADEMIC_MANAGEMENT_DOCS.md](ACADEMIC_MANAGEMENT_DOCS.md) - Manajemen Fakultas & Prodi
-   📙 [STUDENT_MANAGEMENT_DOCS.md](STUDENT_MANAGEMENT_DOCS.md) - Manajemen Mahasiswa
-   📒 [TEMPLATE_MANAGEMENT_BACKEND.md](TEMPLATE_MANAGEMENT_BACKEND.md) - Backend Template
-   📓 [TEMPLATE_MANAGEMENT_VIEWS.md](TEMPLATE_MANAGEMENT_VIEWS.md) - Views Template
-   📔 [VISUAL_RULES_BUILDER_GUIDE.md](VISUAL_RULES_BUILDER_GUIDE.md) - Visual Builder Guide

### 🔧 Technical Documentation

-   � [DATABASE_MIGRATIONS_SUMMARY.md](DATABASE_MIGRATIONS_SUMMARY.md) - Database Schema
-   📝 [BREEZE_AUTH_IMPLEMENTATION.md](BREEZE_AUTH_IMPLEMENTATION.md) - Authentication
-   � [STUDENT_PRODI_DROPDOWN_FIX.md](STUDENT_PRODI_DROPDOWN_FIX.md) - Bug Fixes
-   🧪 [TESTING_GUIDE.md](TESTING_GUIDE.md) - Testing Guide

### 📅 Project Management

-   🗺️ [ROADMAP.md](ROADMAP.md) - Roadmap Proyek
-   🎨 [UI_UX_IMPROVEMENTS.md](UI_UX_IMPROVEMENTS.md) - UI/UX Improvements

---

## 🛠️ Tech Stack

### Backend

-   **Framework:** Laravel 11
-   **Language:** PHP 8.2+
-   **Authentication:** Laravel Breeze
-   **Database:** MySQL 8.0+
-   **ORM:** Eloquent
-   **Document Processing:** PHPWord

### Frontend

-   **Template Engine:** Blade
-   **CSS Framework:** TailwindCSS 3.x
-   **JavaScript:** Alpine.js, Vanilla JS
-   **Build Tool:** Vite
-   **Icons:** Heroicons

### AI & Services

-   **AI Service:** OpenAI GPT-4 (planned)
-   **File Storage:** Laravel Storage
-   **Queue:** Laravel Queue (for background jobs)

---

## � Project Structure

```
Template_in/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/           # Admin controllers
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── FacultyController.php
│   │   │   │   ├── ProgramStudyController.php
│   │   │   │   ├── StudentController.php
│   │   │   │   └── TemplateController.php
│   │   │   ├── Student/         # Student controllers
│   │   │   └── ProfileController.php
│   │   ├── Middleware/          # Custom middleware
│   │   └── Requests/            # Form requests
│   ├── Models/                  # Eloquent models
│   │   ├── Faculty.php
│   │   ├── ProgramStudy.php
│   │   ├── Template.php
│   │   ├── DocumentCheck.php
│   │   └── User.php
│   ├── Services/                # Business logic services
│   │   └── TemplateGeneratorService.php
│   └── View/Components/         # Blade components
│
├── database/
│   ├── migrations/              # Database migrations
│   ├── seeders/                 # Database seeders
│   │   ├── AdminSeeder.php
│   │   ├── FacultySeeder.php
│   │   ├── ProgramStudySeeder.php
│   │   └── StudentSeeder.php
│   └── factories/               # Model factories
│
├── resources/
│   ├── views/
│   │   ├── admin/              # Admin views
│   │   │   ├── dashboard.blade.php
│   │   │   ├── faculties/
│   │   │   ├── program-studies/
│   │   │   ├── students/
│   │   │   └── templates/
│   │   ├── student/            # Student views
│   │   ├── layouts/            # Layout templates
│   │   └── components/         # Reusable components
│   ├── css/
│   │   └── app.css             # TailwindCSS
│   └── js/
│       └── app.js              # JavaScript entry
│
├── routes/
│   ├── web.php                 # Web routes
│   ├── api.php                 # API routes
│   └── auth.php                # Authentication routes
│
├── public/
│   ├── storage/                # Symlink to storage
│   └── build/                  # Compiled assets
│
├── storage/
│   ├── app/
│   │   ├── public/             # Public files
│   │   └── templates/          # Generated .docx files
│   └── logs/                   # Application logs
│
└── tests/                      # Unit & feature tests
    ├── Feature/
    └── Unit/
```

---

## 🗂️ Project Structure

```
Template_in/
├── app/
│   ├── Models/          # Template, DocumentCheck, User, etc.
│   ├── Http/Controllers/
│   └── Services/        # DocumentAnalyzerService (upcoming)
├── database/
│   ├── migrations/      # Database schema
│   └── seeders/         # AdminSeeder, etc.
├── resources/
│   ├── js/             # Frontend components (upcoming)
│   └── views/          # Blade templates
└── routes/
    ├── web.php
    └── api.php
```

---

## �️ Database Schema

### Entity Relationship Diagram

```
                    ┌─────────────┐
                    │  Faculties  │
                    └──────┬──────┘
                           │ 1
               ┌───────────┴───────────┐
               │ N                     │ N
    ┌──────────┴──────────┐   ┌────────┴────────┐
    │  Program Studies    │   │     Users       │
    └──────────┬──────────┘   └────────┬────────┘
               │ 1                     │ 1
               │ N                     │ N
        ┌──────┴────────┐              │
        │   Templates   │              │
        └───────┬───────┘              │
                │ 1                    │
                │ N                    │
                └──────────┬───────────┘
                           │
                    ┌──────┴──────────┐
                    │ Document Checks │
                    └─────────────────┘
```

### Tables

1. **faculties** - Fakultas
2. **program_studies** - Program Studi
3. **users** - Admin & Mahasiswa
4. **templates** - Template Dokumen
5. **document_checks** - Riwayat Pengecekan Dokumen

Lihat detail lengkap di [SYSTEM_DESIGN_DFD_ERD.md](SYSTEM_DESIGN_DFD_ERD.md)

---

## 🎯 Workflow Sistem

### Admin Workflow

1. **Login** sebagai admin
2. **Setup Data Master** - Buat fakultas dan program studi
3. **Manage Students** - Tambah/edit data mahasiswa
4. **Create Template** - Buat template menggunakan Visual Builder
5. **Generate .docx** - Auto-generate file Word
6. **Activate Template** - Aktifkan template untuk mahasiswa
7. **Monitor Usage** - Lihat statistik di dashboard

### Student Workflow

1. **Login** sebagai mahasiswa
2. **Browse Templates** - Lihat template sesuai fakultas/prodi
3. **Download Template** - Download file .docx
4. **Work on Document** - Kerjakan dokumen menggunakan template
5. **Upload for Check** - Upload dokumen untuk dicek
6. **View Results** - Lihat hasil pengecekan dan saran
7. **Revise Document** - Perbaiki sesuai saran AI

---

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter TemplateTest

# Run with coverage
php artisan test --coverage

# Run specific test suite
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit
```

Lihat panduan lengkap di [TESTING_GUIDE.md](TESTING_GUIDE.md)

---

## 🚨 Troubleshooting

### Dropdown Program Studi Tidak Muncul

Lihat panduan lengkap di [STUDENT_PRODI_DROPDOWN_FIX.md](STUDENT_PRODI_DROPDOWN_FIX.md)

### Template Generation Gagal

1. Pastikan folder `storage/app/templates` ada dan writable
2. Cek logs di `storage/logs/laravel.log`
3. Pastikan PHPWord terinstall dengan benar

### Error 500 Setelah Deploy

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Permission Issues

```bash
# Linux/Mac
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Windows - Run as Administrator
icacls storage /grant Users:F /t
icacls bootstrap/cache /grant Users:F /t
```

---

## 🔧 Useful Commands

### Development

```bash
# Start Laravel server
php artisan serve

# Start Vite dev server (hot reload)
npm run dev

# Watch for changes
npm run watch

# Run queue worker
php artisan queue:work
```

### Database

```bash
# Run migrations
php artisan migrate

# Fresh migration with seeding
php artisan migrate:fresh --seed

# Seed database only
php artisan db:seed

# Specific seeder
php artisan db:seed --class=AdminSeeder
```

### Cache Management

```bash
# Clear all cache
php artisan optimize:clear

# Individual cache clear
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Create cache (production)
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Storage

```bash
# Create storage symlink
php artisan storage:link

# Clear compiled views
php artisan view:clear
```

### Maintenance

```bash
# Put app in maintenance mode
php artisan down

# Bring app back online
php artisan up

# Check app version
php artisan --version
```

---

## 🌐 Deployment

### Production Deployment Checklist

1. **Environment Setup**

    ```bash
    cp .env.example .env
    # Edit .env dengan production settings
    php artisan key:generate
    ```

2. **Install Dependencies**

    ```bash
    composer install --optimize-autoloader --no-dev
    npm install
    npm run build
    ```

3. **Database**

    ```bash
    php artisan migrate --force
    php artisan db:seed --class=AdminSeeder --force
    ```

4. **Optimize**

    ```bash
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    ```

5. **Storage**

    ```bash
    php artisan storage:link
    chmod -R 775 storage bootstrap/cache
    ```

6. **Security**
    - Set `APP_DEBUG=false`
    - Set `APP_ENV=production`
    - Configure proper file permissions
    - Setup SSL certificate
    - Configure firewall

---

## 📊 Performance Optimization

-   ✅ Query optimization dengan eager loading
-   ✅ Cache configuration dan routes
-   ✅ Asset compilation dengan Vite
-   ✅ Database indexing pada foreign keys
-   ✅ Lazy loading untuk komponetent besar
-   ⏳ Redis untuk session dan cache (planned)
-   ⏳ Queue untuk background jobs (planned)

---

## 🔐 Security

-   ✅ CSRF protection pada semua form
-   ✅ SQL injection prevention (Eloquent ORM)
-   ✅ XSS protection (Blade templating)
-   ✅ Password hashing (bcrypt)
-   ✅ Role-based access control (Admin/Student)
-   ✅ File upload validation
-   ⏳ Rate limiting API (planned)
-   ⏳ Two-factor authentication (planned)

---

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## 👥 Team & Contributors

### Development Team

-   **Lead Developer:** Indra
-   **Repository:** [Templatein_Ai](https://github.com/Indraaai/Templatein_Ai)
-   **Project Type:** Academic Document Template Management System
-   **Version:** 1.0.0
-   **Last Updated:** October 20, 2025

### Tech Stack Credits

-   Laravel Framework
-   TailwindCSS
-   PHPWord Library
-   Alpine.js
-   Heroicons

---

## 📞 Support & Contact

Untuk pertanyaan, bug report, atau feature request:

-   **GitHub Issues:** [Create an issue](https://github.com/Indraaai/Templatein_Ai/issues)
-   **Email:** [Your Email]

---

## 🙏 Acknowledgments

Terima kasih kepada:

-   Laravel Community
-   Open Source Contributors
-   Academic Institutions yang memberikan feedback
-   Semua yang telah berkontribusi pada project ini

---

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

-   **[Vehikl](https://vehikl.com)**
-   **[Tighten Co.](https://tighten.co)**
-   **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
-   **[64 Robots](https://64robots.com)**
-   **[Curotec](https://www.curotec.com/services/technologies/laravel)**
-   **[DevSquad](https://devsquad.com/hire-laravel-developers)**
-   **[Redberry](https://redberry.international/laravel-development)**
-   **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
