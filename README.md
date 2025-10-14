# 📄 Template Document Checker with AI

Sistem untuk admin membuat template dokumen akademik dengan auto-generate file .docx, mahasiswa dapat download template sesuai fakultas/prodi, dan mengecek struktur dokumen mereka menggunakan AI.

---

## 🚀 Quick Start

### 1. Install Dependencies

```powershell
composer install
npm install
```

### 2. Setup Environment

```powershell
cp .env.example .env
php artisan key:generate
```

### 3. Database Setup

```powershell
# Edit .env file dengan database credentials Anda
php artisan migrate:fresh --seed
```

### 4. Run Development Server

```powershell
php artisan serve
npm run dev
```

---

## 👤 Default Admin Account

Setelah menjalankan seeder, Anda bisa login sebagai admin dengan:

```
📧 Email: admin@template.test
🔑 Password: admin123
```

**⚠️ PENTING:** Ganti password default ini setelah login pertama kali!

### Manual Seeding Admin

```powershell
php artisan db:seed --class=AdminSeeder
```

---

## 📋 Documentation

-   📘 [ROADMAP.md](ROADMAP.md) - Roadmap lengkap pembangunan proyek
-   📗 [DATABASE_MIGRATIONS_SUMMARY.md](DATABASE_MIGRATIONS_SUMMARY.md) - Ringkasan database & migrations
-   📕 [ADMIN_SEEDER_DOCS.md](ADMIN_SEEDER_DOCS.md) - Dokumentasi admin seeder

---

## 🛠️ Tech Stack

-   **Backend:** Laravel 11
-   **Frontend:** React/Vue + TailwindCSS (upcoming)
-   **Database:** MySQL
-   **AI:** OpenAI GPT-4
-   **Document Processing:** PHPWord

---

## 📦 Features

-   ✅ Admin dapat membuat template dokumen
-   ✅ Auto-generate file .docx dari rules
-   ✅ Mahasiswa download template sesuai fakultas/prodi
-   ✅ Upload dokumen untuk pengecekan AI
-   ✅ Analisis struktur dokumen dengan AI
-   ✅ Feedback & suggestions dari AI

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

## 📌 Database Schema

```
faculties (1) ──→ (N) program_studies
faculties (1) ──→ (N) users
faculties (1) ──→ (N) templates

program_studies (1) ──→ (N) users
program_studies (1) ──→ (N) templates

users (1) ──→ (N) document_checks
templates (1) ──→ (N) document_checks
```

---

## 🧪 Testing

```powershell
# Run all tests
php artisan test

# Run specific test
php artisan test --filter TemplateTest

# With coverage
php artisan test --coverage
```

---

## 🔧 Useful Commands

```powershell
# Development
php artisan serve
npm run dev
php artisan queue:work

# Database
php artisan migrate
php artisan db:seed
php artisan migrate:fresh --seed

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

---

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## 👥 Contributors

-   **Developer:** [Your Name]
-   **Project:** Template Document Checker with AI
-   **Version:** 1.0.0
-   **Last Updated:** October 14, 2025

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
