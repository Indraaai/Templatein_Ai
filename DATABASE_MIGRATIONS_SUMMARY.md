# ✅ Database Migrations - Summary

## Migrations yang Telah Dibuat

### 1. Migration: `create_document_checks_table`

**File:** `database/migrations/2025_10_14_163959_create_document_checks_table.php`

**Struktur Tabel:**

```sql
- id (bigint, PK)
- user_id (bigint, FK -> users)
- template_id (bigint, FK -> templates)
- original_filename (varchar)
- file_path (varchar)
- file_type (varchar, nullable)
- file_size (int, nullable)
- ai_result (json, nullable)
- violations (json, nullable)
- suggestions (json, nullable)
- compliance_score (int, nullable)
- check_status (enum: pending|processing|completed|failed, default: pending)
- created_at (timestamp)
- updated_at (timestamp)
```

**Relasi:**

-   `user_id` → `users.id` (CASCADE on delete)
-   `template_id` → `templates.id` (CASCADE on delete)

---

### 2. Migration: `add_template_file_columns_to_templates_table`

**File:** `database/migrations/2025_10_14_164100_add_template_file_columns_to_templates_table.php`

**Kolom yang Ditambahkan ke Tabel `templates`:**

```sql
- description (text, nullable) - Deskripsi template
- file_path (varchar, nullable) - Path file template yang di-generate
- is_active (boolean, default: true) - Status aktif/tidak
- download_count (int, default: 0) - Counter jumlah download
```

---

## Models yang Telah Dibuat/Diupdate

### 1. Model: `DocumentCheck`

**File:** `app/Models/DocumentCheck.php`

**Features:**

-   ✅ Fillable fields lengkap
-   ✅ Casts untuk JSON fields (ai_result, violations, suggestions)
-   ✅ Relasi ke User dan Template
-   ✅ Helper methods: `isCompleted()`, `isPassed()`

**Relasi:**

```php
belongsTo(User::class)
belongsTo(Template::class)
```

---

### 2. Model: `Template` (Updated)

**File:** `app/Models/Template.php`

**Updates:**

-   ✅ Tambah fillable: `description`, `file_path`, `is_active`, `download_count`
-   ✅ Tambah cast: `is_active` → boolean
-   ✅ Tambah relasi: `hasMany(DocumentCheck::class)`
-   ✅ Tambah method: `incrementDownload()`

**Relasi:**

```php
belongsTo(Faculty::class)
belongsTo(ProgramStudy::class)
hasMany(DocumentCheck::class)
```

---

### 3. Model: `User` (Updated)

**File:** `app/Models/User.php`

**Updates:**

-   ✅ Tambah relasi: `hasMany(DocumentCheck::class)`

**Relasi:**

```php
belongsTo(Faculty::class)
belongsTo(ProgramStudy::class)
hasMany(DocumentCheck::class)
```

---

## Database Schema Lengkap

### ERD Relationship:

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

## Migration Status

✅ **Semua migration berhasil dijalankan!**

```powershell
php artisan migrate:fresh
```

**Output:**

```
✓ 0001_01_01_000001_create_cache_table
✓ 0001_01_01_000002_create_jobs_table
✓ 2025_10_14_062935_create_faculties_table
✓ 2025_10_14_062942_create_program_studies_table
✓ 2025_10_14_062947_create_templates_table
✓ 2025_10_14_062950_create_users_table
✓ 2025_10_14_163959_create_document_checks_table (NEW!)
✓ 2025_10_14_164100_add_template_file_columns_to_templates_table (NEW!)
```

---

## Next Steps

### 1. Create Seeders

```powershell
php artisan make:seeder FacultySeeder
php artisan make:seeder ProgramStudySeeder
php artisan make:seeder UserSeeder
```

### 2. Run Seeders

```powershell
php artisan db:seed
# atau
php artisan migrate:fresh --seed
```

### 3. Create Controllers

```powershell
php artisan make:controller Admin/TemplateController --resource
php artisan make:controller Student/TemplateController
php artisan make:controller Student/DocumentCheckController
```

### 4. Create Services

```powershell
# Buat manual
mkdir app/Services
# File: app/Services/DocumentAnalyzerService.php
```

### 5. Create Jobs

```powershell
php artisan make:job ProcessDocumentCheck
```

---

## Testing

Untuk test relasi dan model:

```php
// Test relasi
$user = User::first();
$checks = $user->documentChecks; // Ambil semua document checks user

$template = Template::first();
$checks = $template->documentChecks; // Ambil semua checks untuk template

$documentCheck = DocumentCheck::first();
$user = $documentCheck->user;
$template = $documentCheck->template;

// Test methods
if ($documentCheck->isCompleted()) {
    echo "Check completed!";
}

if ($documentCheck->isPassed()) {
    echo "Document passed!";
}

// Test increment download
$template->incrementDownload();
```

---

**Created:** October 14, 2025
**Status:** ✅ Complete
**Phase:** FASE 1 - Database Foundation (DONE!)
