# 📋 Roadmap Pembangunan Proyek Template Document Checker

## 🎯 Overview Proyek

Sistem untuk admin membuat template dokumen akademik dengan auto-generate file .docx, mahasiswa dapat download template sesuai fakultas/prodi, dan mengecek struktur dokumen mereka menggunakan AI.

---

## 📌 FASE 1: Setup & Database Foundation

### 1.1 Install Dependencies

```powershell
# Install Laravel PHPWord untuk generate dokumen
composer require phpoffice/phpword

# Install package untuk AI integration (pilih salah satu)
composer require openai-php/client  # Untuk OpenAI
# atau
composer require anthropic-php/client  # Untuk Claude AI
```

### 1.2 Database Migrations

**Status: ✅ Sudah dibuat**

-   [x] `faculties` - Tabel fakultas
-   [x] `program_studies` - Tabel program studi
-   [x] `users` - Tabel users (admin & mahasiswa)
-   [x] `templates` - Tabel template dokumen
-   [x] `cache` & `jobs` - Tabel sistem cache & queue

**Perlu ditambahkan:**

```powershell
# Migration untuk document checks
php artisan make:migration create_document_checks_table

# Migration untuk update templates (tambah kolom)
php artisan make:migration add_template_file_columns_to_templates_table --table=templates
```

### 1.3 Jalankan Migration

```powershell
php artisan migrate:fresh
```

---

## 📌 FASE 2: Models & Relationships

### 2.1 Update Model Template

**File: `app/Models/Template.php`**

**Fitur yang perlu ditambahkan:**

-   [x] Fillable fields dasar
-   [x] Relasi ke Faculty & ProgramStudy
-   [ ] Method `generateTemplateFile()` - Generate .docx otomatis
-   [ ] Method `addRuleToDocument()` - Parsing rules ke struktur dokumen
-   [ ] Method `incrementDownload()` - Counter download

**Kolom yang perlu ditambah:**

```php
'description',      // Deskripsi template
'file_path',        // Path file .docx yang di-generate
'is_active',        // Status aktif/tidak
'download_count',   // Jumlah download
```

### 2.2 Buat Model DocumentCheck

```powershell
php artisan make:model DocumentCheck
```

**File: `app/Models/DocumentCheck.php`**

**Fields:**

-   `user_id` - FK ke users
-   `template_id` - FK ke templates
-   `original_filename` - Nama file asli
-   `file_path` - Path file yang diupload
-   `file_type` - Tipe file (docx, pdf)
-   `file_size` - Ukuran file
-   `ai_result` - Hasil analisis AI (JSON)
-   `violations` - Pelanggaran yang ditemukan (JSON)
-   `suggestions` - Saran perbaikan (JSON)
-   `compliance_score` - Score 0-100
-   `check_status` - Status: pending, processing, completed, failed

**Relasi:**

-   `belongsTo(User::class)`
-   `belongsTo(Template::class)`

### 2.3 Update Model User

**File: `app/Models/User.php`**

Tambahkan relasi:

```php
public function documentChecks()
{
    return $this->hasMany(DocumentCheck::class);
}

public function faculty()
{
    return $this->belongsTo(Faculty::class);
}

public function programStudy()
{
    return $this->belongsTo(ProgramStudy::class);
}
```

---

## 📌 FASE 3: Seeders untuk Data Awal

### 3.1 Buat Seeders

```powershell
php artisan make:seeder FacultySeeder
php artisan make:seeder ProgramStudySeeder
php artisan make:seeder UserSeeder
```

### 3.2 Isi Data Sample

**FacultySeeder:**

```php
<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    public function run(): void
    {
        $faculties = [
            ['name' => 'Fakultas Teknik'],
            ['name' => 'Fakultas Ekonomi dan Bisnis'],
            ['name' => 'Fakultas MIPA'],
            ['name' => 'Fakultas Ilmu Sosial dan Politik'],
            ['name' => 'Fakultas Hukum'],
        ];

        foreach ($faculties as $faculty) {
            Faculty::create($faculty);
        }
    }
}
```

**ProgramStudySeeder:**

```php
<?php

namespace Database\Seeders;

use App\Models\ProgramStudy;
use Illuminate\Database\Seeder;

class ProgramStudySeeder extends Seeder
{
    public function run(): void
    {
        $programStudies = [
            // Fakultas Teknik
            ['faculty_id' => 1, 'name' => 'Teknik Informatika'],
            ['faculty_id' => 1, 'name' => 'Sistem Informasi'],
            ['faculty_id' => 1, 'name' => 'Teknik Elektro'],
            ['faculty_id' => 1, 'name' => 'Teknik Sipil'],

            // Fakultas Ekonomi
            ['faculty_id' => 2, 'name' => 'Manajemen'],
            ['faculty_id' => 2, 'name' => 'Akuntansi'],

            // Fakultas MIPA
            ['faculty_id' => 3, 'name' => 'Matematika'],
            ['faculty_id' => 3, 'name' => 'Fisika'],
        ];

        foreach ($programStudies as $prodi) {
            ProgramStudy::create($prodi);
        }
    }
}
```

**UserSeeder:**

```php
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Sistem',
            'email' => 'admin@template.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Mahasiswa Sample
        User::create([
            'name' => 'John Doe',
            'email' => 'mahasiswa@template.test',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'faculty_id' => 1,
            'program_study_id' => 1,
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'mahasiswa2@template.test',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'faculty_id' => 2,
            'program_study_id' => 5,
        ]);
    }
}
```

### 3.3 Update DatabaseSeeder

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            FacultySeeder::class,
            ProgramStudySeeder::class,
            UserSeeder::class,
        ]);
    }
}
```

### 3.4 Jalankan Seeder

```powershell
php artisan db:seed
# atau
php artisan migrate:fresh --seed
```

---

## 📌 FASE 4: Backend API & Controllers

### 4.1 Admin - Template Management

**Buat Controller:**

```powershell
php artisan make:controller Admin/TemplateController --resource
```

**File: `app/Http/Controllers/Admin/TemplateController.php`**

**Endpoints yang perlu dibuat:**

-   `POST /api/admin/templates` - Buat template baru & auto-generate file
-   `GET /api/admin/templates` - List semua template
-   `GET /api/admin/templates/{id}` - Detail template
-   `PUT /api/admin/templates/{id}` - Update template
-   `POST /api/admin/templates/{id}/regenerate` - Regenerate file template
-   `DELETE /api/admin/templates/{id}` - Hapus template

**Contoh Implementation:**

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    /**
     * Display a listing of templates
     */
    public function index()
    {
        $templates = Template::with(['faculty', 'programStudy'])
            ->latest()
            ->paginate(10);

        return response()->json($templates);
    }

    /**
     * Store a newly created template
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'faculty_id' => 'required|exists:faculties,id',
            'program_study_id' => 'required|exists:program_studies,id',
            'rules' => 'required|array',
            'description' => 'nullable|string',
        ]);

        // Buat template
        $template = Template::create($validated);

        // Generate file .docx otomatis
        try {
            $filePath = $template->generateTemplateFile();

            return response()->json([
                'success' => true,
                'message' => 'Template berhasil dibuat dan file generated!',
                'data' => $template->load(['faculty', 'programStudy']),
                'file_path' => $filePath
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Template dibuat tapi gagal generate file: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified template
     */
    public function show(Template $template)
    {
        return response()->json($template->load(['faculty', 'programStudy']));
    }

    /**
     * Update the specified template
     */
    public function update(Request $request, Template $template)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'type' => 'sometimes|string',
            'faculty_id' => 'sometimes|exists:faculties,id',
            'program_study_id' => 'sometimes|exists:program_studies,id',
            'rules' => 'sometimes|array',
            'description' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $template->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Template berhasil diupdate!',
            'data' => $template->load(['faculty', 'programStudy'])
        ]);
    }

    /**
     * Regenerate template file
     */
    public function regenerate(Template $template)
    {
        try {
            $filePath = $template->generateTemplateFile();

            return response()->json([
                'success' => true,
                'message' => 'Template file berhasil di-regenerate!',
                'file_path' => $filePath
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal regenerate template: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified template
     */
    public function destroy(Template $template)
    {
        // Hapus file jika ada
        if ($template->file_path && Storage::disk('public')->exists($template->file_path)) {
            Storage::disk('public')->delete($template->file_path);
        }

        $template->delete();

        return response()->json([
            'success' => true,
            'message' => 'Template berhasil dihapus!'
        ]);
    }
}
```

### 4.2 Student - Template Download

**Buat Controller:**

```powershell
php artisan make:controller Student/TemplateController
```

**File: `app/Http/Controllers/Student/TemplateController.php`**

**Endpoints:**

-   `GET /api/student/templates` - List template sesuai fakultas & prodi mahasiswa
-   `GET /api/student/templates/{id}/download` - Download file template
-   `GET /api/student/templates/{id}` - Lihat detail & rules template

**Contoh Implementation:**

```php
<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemplateController extends Controller
{
    /**
     * Display templates for student's faculty & prodi
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $templates = Template::where('is_active', true)
            ->where(function ($query) use ($user) {
                $query->where('faculty_id', $user->faculty_id)
                      ->orWhereNull('faculty_id');
            })
            ->where(function ($query) use ($user) {
                $query->where('program_study_id', $user->program_study_id)
                      ->orWhereNull('program_study_id');
            })
            ->with(['faculty', 'programStudy'])
            ->latest()
            ->get();

        return response()->json($templates);
    }

    /**
     * Show template detail
     */
    public function show(Template $template)
    {
        return response()->json($template->load(['faculty', 'programStudy']));
    }

    /**
     * Download template file
     */
    public function download(Template $template)
    {
        if (!$template->file_path || !Storage::disk('public')->exists($template->file_path)) {
            return response()->json([
                'success' => false,
                'message' => 'File template tidak ditemukan'
            ], 404);
        }

        // Increment download count
        $template->incrementDownload();

        return Storage::disk('public')->download(
            $template->file_path,
            $template->name . '.docx'
        );
    }
}
```

### 4.3 Student - Document Check

**Buat Controller:**

```powershell
php artisan make:controller Student/DocumentCheckController
```

**File: `app/Http/Controllers/Student/DocumentCheckController.php`**

**Endpoints:**

-   `POST /api/student/document-checks` - Upload dokumen untuk dicek
-   `GET /api/student/document-checks` - History pengecekan dokumen
-   `GET /api/student/document-checks/{id}` - Detail hasil pengecekan

**Contoh Implementation:**

```php
<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\DocumentCheck;
use App\Jobs\ProcessDocumentCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentCheckController extends Controller
{
    /**
     * Display student's document check history
     */
    public function index(Request $request)
    {
        $documentChecks = DocumentCheck::where('user_id', $request->user()->id)
            ->with('template')
            ->latest()
            ->paginate(10);

        return response()->json($documentChecks);
    }

    /**
     * Upload document for checking
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'template_id' => 'required|exists:templates,id',
            'document' => 'required|file|mimes:docx,pdf|max:10240', // Max 10MB
        ]);

        $user = $request->user();
        $file = $request->file('document');

        // Simpan file
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('documents/user_' . $user->id, $fileName, 'public');

        // Buat document check record
        $documentCheck = DocumentCheck::create([
            'user_id' => $user->id,
            'template_id' => $validated['template_id'],
            'original_filename' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'file_type' => $file->getClientOriginalExtension(),
            'file_size' => $file->getSize(),
            'check_status' => 'pending',
        ]);

        // Dispatch job untuk AI processing
        ProcessDocumentCheck::dispatch($documentCheck);

        return response()->json([
            'success' => true,
            'message' => 'Dokumen berhasil diupload dan sedang diproses!',
            'data' => $documentCheck->load('template')
        ], 201);
    }

    /**
     * Show document check result
     */
    public function show(DocumentCheck $documentCheck)
    {
        // Pastikan user hanya bisa akses dokumen miliknya
        if ($documentCheck->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        return response()->json($documentCheck->load('template'));
    }
}
```

### 4.4 Setup Routes

**File: `routes/api.php`**

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TemplateController as AdminTemplateController;
use App\Http\Controllers\Student\TemplateController as StudentTemplateController;
use App\Http\Controllers\Student\DocumentCheckController;

// Admin routes
Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    Route::apiResource('templates', AdminTemplateController::class);
    Route::post('templates/{template}/regenerate', [AdminTemplateController::class, 'regenerate']);
});

// Student routes
Route::middleware(['auth:sanctum', 'role:mahasiswa'])->prefix('student')->group(function () {
    Route::get('templates', [StudentTemplateController::class, 'index']);
    Route::get('templates/{template}', [StudentTemplateController::class, 'show']);
    Route::get('templates/{template}/download', [StudentTemplateController::class, 'download']);

    Route::get('document-checks', [DocumentCheckController::class, 'index']);
    Route::post('document-checks', [DocumentCheckController::class, 'store']);
    Route::get('document-checks/{documentCheck}', [DocumentCheckController::class, 'show']);
});
```

### 4.5 Buat Middleware Role

```powershell
php artisan make:middleware RoleMiddleware
```

**File: `app/Http/Middleware/RoleMiddleware.php`**

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!$request->user() || $request->user()->role !== $role) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        return $next($request);
    }
}
```

**Register di `bootstrap/app.php`:**

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ]);
})
```

---

## 📌 FASE 5: AI Integration Service

### 5.1 Install OpenAI Client

```powershell
composer require openai-php/client
```

### 5.2 Buat Service Class

```powershell
# Buat folder Services jika belum ada
mkdir app/Services

# Buat file DocumentAnalyzerService.php
```

**File: `app/Services/DocumentAnalyzerService.php`**

```php
<?php

namespace App\Services;

use PhpOffice\PhpWord\IOFactory;
use OpenAI\Client;
use Illuminate\Support\Facades\Storage;

class DocumentAnalyzerService
{
    protected $openai;

    public function __construct()
    {
        $this->openai = \OpenAI::client(config('services.openai.api_key'));
    }

    /**
     * Ekstrak text dari dokumen .docx
     */
    public function extractTextFromDocument(string $filePath): string
    {
        $fullPath = Storage::disk('public')->path($filePath);

        try {
            $phpWord = IOFactory::load($fullPath);
            $text = '';

            foreach ($phpWord->getSections() as $section) {
                foreach ($section->getElements() as $element) {
                    if (method_exists($element, 'getText')) {
                        $text .= $element->getText() . "\n";
                    }
                }
            }

            return $text;
        } catch (\Exception $e) {
            throw new \Exception('Gagal ekstrak text: ' . $e->getMessage());
        }
    }

    /**
     * Analisis struktur dokumen dengan AI
     */
    public function analyzeStructure(string $text, array $templateRules): array
    {
        $prompt = $this->buildAnalysisPrompt($text, $templateRules);

        try {
            $response = $this->openai->chat()->create([
                'model' => 'gpt-4',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Anda adalah asisten analisis dokumen akademik. Tugas Anda adalah menganalisis struktur dokumen dan memberikan feedback yang detail.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'temperature' => 0.3,
            ]);

            $result = json_decode($response->choices[0]->message->content, true);

            return [
                'ai_result' => $result,
                'violations' => $result['violations'] ?? [],
                'suggestions' => $result['suggestions'] ?? [],
                'compliance_score' => $result['compliance_score'] ?? 0,
            ];
        } catch (\Exception $e) {
            throw new \Exception('Gagal analisis dengan AI: ' . $e->getMessage());
        }
    }

    /**
     * Build prompt untuk AI
     */
    protected function buildAnalysisPrompt(string $text, array $rules): string
    {
        return "
Analisis dokumen berikut berdasarkan aturan template yang diberikan.

ATURAN TEMPLATE:
" . json_encode($rules, JSON_PRETTY_PRINT) . "

ISI DOKUMEN:
" . substr($text, 0, 8000) . "

Berikan analisis dalam format JSON dengan struktur berikut:
{
    \"violations\": [
        {
            \"severity\": \"error|warning|info\",
            \"rule\": \"nama rule yang dilanggar\",
            \"description\": \"penjelasan pelanggaran\",
            \"location\": \"bagian dokumen\"
        }
    ],
    \"suggestions\": [
        {
            \"priority\": \"high|medium|low\",
            \"title\": \"judul saran\",
            \"description\": \"detail saran perbaikan\",
            \"example\": \"contoh implementasi\"
        }
    ],
    \"compliance_score\": 0-100,
    \"summary\": \"ringkasan analisis\"
}

Fokus pada:
1. Struktur dokumen (heading, paragraph, format)
2. Kelengkapan bagian-bagian yang diwajibkan
3. Format penulisan (bold, size, alignment)
4. Urutan bagian dokumen
5. Konsistensi penulisan
";
    }
}
```

### 5.3 Setup Configuration

**File: `config/services.php`**

```php
return [
    // ... existing services

    'openai' => [
        'api_key' => env('OPENAI_API_KEY'),
    ],
];
```

**File: `.env`**

```env
OPENAI_API_KEY=your-openai-api-key-here
```

---

## 📌 FASE 6: Queue & Jobs untuk AI Processing

### 6.1 Setup Queue

**File: `.env`**

```env
QUEUE_CONNECTION=database
```

**Buat tabel jobs:**

```powershell
php artisan queue:table
php artisan migrate
```

### 6.2 Buat Job untuk AI Processing

```powershell
php artisan make:job ProcessDocumentCheck
```

**File: `app/Jobs/ProcessDocumentCheck.php`**

```php
<?php

namespace App\Jobs;

use App\Models\DocumentCheck;
use App\Services\DocumentAnalyzerService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessDocumentCheck implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $documentCheck;

    /**
     * Create a new job instance.
     */
    public function __construct(DocumentCheck $documentCheck)
    {
        $this->documentCheck = $documentCheck;
    }

    /**
     * Execute the job.
     */
    public function handle(DocumentAnalyzerService $analyzer): void
    {
        try {
            // Update status ke processing
            $this->documentCheck->update(['check_status' => 'processing']);

            // Ekstrak text dari dokumen
            $text = $analyzer->extractTextFromDocument($this->documentCheck->file_path);

            // Ambil template rules
            $template = $this->documentCheck->template;
            $rules = $template->rules;

            // Analisis dengan AI
            $analysis = $analyzer->analyzeStructure($text, $rules);

            // Update document check dengan hasil
            $this->documentCheck->update([
                'ai_result' => $analysis['ai_result'],
                'violations' => $analysis['violations'],
                'suggestions' => $analysis['suggestions'],
                'compliance_score' => $analysis['compliance_score'],
                'check_status' => 'completed',
            ]);

            Log::info('Document check completed', [
                'document_check_id' => $this->documentCheck->id,
                'score' => $analysis['compliance_score']
            ]);

        } catch (\Exception $e) {
            // Update status ke failed
            $this->documentCheck->update([
                'check_status' => 'failed',
                'ai_result' => [
                    'error' => $e->getMessage()
                ]
            ]);

            Log::error('Document check failed', [
                'document_check_id' => $this->documentCheck->id,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Job ProcessDocumentCheck failed', [
            'document_check_id' => $this->documentCheck->id,
            'exception' => $exception->getMessage()
        ]);
    }
}
```

### 6.3 Jalankan Queue Worker

```powershell
# Development
php artisan queue:work

# Production (dengan supervisor)
php artisan queue:work --daemon --tries=3 --timeout=300
```

### 6.4 Setup Supervisor (Production)

**File: `/etc/supervisor/conf.d/template-worker.conf`**

```ini
[program:template-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/path/to/storage/logs/worker.log
stopwaitsecs=3600
```

---

## 📌 FASE 7: Frontend Development

### 7.1 Setup Frontend

```powershell
# Install dependencies
npm install

# Install additional packages
npm install @headlessui/react @heroicons/react axios zustand react-hook-form
```

### 7.2 Admin Dashboard - Template Management

**Struktur Folder:**

```
resources/js/
├── Pages/
│   ├── Admin/
│   │   ├── Templates/
│   │   │   ├── Index.jsx
│   │   │   ├── Create.jsx
│   │   │   ├── Edit.jsx
│   │   │   └── Show.jsx
│   │   └── Dashboard.jsx
│   └── Student/
│       ├── Templates/
│       │   ├── Index.jsx
│       │   └── Show.jsx
│       └── DocumentChecks/
│           ├── Index.jsx
│           ├── Create.jsx
│           └── Show.jsx
└── Components/
    ├── Admin/
    │   ├── RulesBuilder.jsx
    │   ├── RuleItem.jsx
    │   └── TemplatePreview.jsx
    ├── Student/
    │   ├── TemplateCard.jsx
    │   ├── DocumentUploader.jsx
    │   ├── CheckResultCard.jsx
    │   ├── ViolationList.jsx
    │   └── ComplianceScore.jsx
    └── Shared/
        ├── Navbar.jsx
        ├── Sidebar.jsx
        └── Layout.jsx
```

### 7.3 Key Components

**RulesBuilder Component:**

```jsx
// resources/js/Components/Admin/RulesBuilder.jsx
import { useState } from "react";

export default function RulesBuilder({ value = [], onChange }) {
    const [rules, setRules] = useState(value);

    const addRule = (type) => {
        const newRule = {
            id: Date.now(),
            type: type,
            text: "",
            format: {},
            validation: {},
        };

        const updated = [...rules, newRule];
        setRules(updated);
        onChange(updated);
    };

    const updateRule = (id, updates) => {
        const updated = rules.map((rule) =>
            rule.id === id ? { ...rule, ...updates } : rule
        );
        setRules(updated);
        onChange(updated);
    };

    const removeRule = (id) => {
        const updated = rules.filter((rule) => rule.id !== id);
        setRules(updated);
        onChange(updated);
    };

    return (
        <div className="space-y-4">
            <div className="flex gap-2">
                <button onClick={() => addRule("heading")} className="btn">
                    Add Heading
                </button>
                <button onClick={() => addRule("paragraph")} className="btn">
                    Add Paragraph
                </button>
                <button onClick={() => addRule("list")} className="btn">
                    Add List
                </button>
            </div>

            <div className="space-y-2">
                {rules.map((rule, index) => (
                    <RuleItem
                        key={rule.id}
                        rule={rule}
                        index={index}
                        onUpdate={(updates) => updateRule(rule.id, updates)}
                        onRemove={() => removeRule(rule.id)}
                    />
                ))}
            </div>
        </div>
    );
}
```

---

## 📌 FASE 8: Testing

### 8.1 Setup Testing

```powershell
# Buat database testing
# Edit .env.testing

# Jalankan migration untuk testing
php artisan migrate --env=testing
```

### 8.2 Unit Tests

```powershell
# Test Models
php artisan make:test TemplateTest --unit
php artisan make:test DocumentCheckTest --unit
```

**File: `tests/Unit/TemplateTest.php`**

```php
<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Template;
use App\Models\Faculty;
use App\Models\ProgramStudy;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TemplateTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_template()
    {
        $faculty = Faculty::factory()->create();
        $prodi = ProgramStudy::factory()->create(['faculty_id' => $faculty->id]);

        $template = Template::create([
            'name' => 'Test Template',
            'type' => 'skripsi',
            'faculty_id' => $faculty->id,
            'program_study_id' => $prodi->id,
            'rules' => [['type' => 'heading', 'text' => 'BAB I']],
        ]);

        $this->assertDatabaseHas('templates', [
            'name' => 'Test Template',
            'type' => 'skripsi',
        ]);
    }

    public function test_template_has_relations()
    {
        $template = Template::factory()->create();

        $this->assertInstanceOf(Faculty::class, $template->faculty);
        $this->assertInstanceOf(ProgramStudy::class, $template->programStudy);
    }
}
```

### 8.3 Feature Tests

```powershell
php artisan make:test TemplateControllerTest
```

**File: `tests/Feature/TemplateControllerTest.php`**

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Template;
use App\Models\Faculty;
use App\Models\ProgramStudy;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TemplateControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_template()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $faculty = Faculty::factory()->create();
        $prodi = ProgramStudy::factory()->create(['faculty_id' => $faculty->id]);

        $response = $this->actingAs($admin)->postJson('/api/admin/templates', [
            'name' => 'Skripsi Teknik Informatika',
            'type' => 'skripsi',
            'faculty_id' => $faculty->id,
            'program_study_id' => $prodi->id,
            'rules' => [
                ['type' => 'heading', 'level' => 1, 'text' => 'BAB I PENDAHULUAN']
            ],
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('templates', [
            'name' => 'Skripsi Teknik Informatika',
        ]);
    }

    public function test_student_can_view_templates()
    {
        $faculty = Faculty::factory()->create();
        $prodi = ProgramStudy::factory()->create(['faculty_id' => $faculty->id]);

        $student = User::factory()->create([
            'role' => 'mahasiswa',
            'faculty_id' => $faculty->id,
            'program_study_id' => $prodi->id,
        ]);

        Template::factory()->create([
            'faculty_id' => $faculty->id,
            'program_study_id' => $prodi->id,
            'is_active' => true,
        ]);

        $response = $this->actingAs($student)->getJson('/api/student/templates');

        $response->assertStatus(200)
                 ->assertJsonCount(1);
    }
}
```

### 8.4 Jalankan Tests

```powershell
# Jalankan semua test
php artisan test

# Jalankan specific test
php artisan test --filter TemplateTest

# Dengan coverage
php artisan test --coverage
```

---

## 📌 FASE 9: Security & Optimization

### 9.1 Rate Limiting

**File: `app/Http/Kernel.php` atau `bootstrap/app.php`**

```php
// API Rate Limiting
RateLimiter::for('api', function (Request $request) {
    return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
});

// Upload Rate Limiting
RateLimiter::for('uploads', function (Request $request) {
    return Limit::perMinute(10)->by($request->user()->id);
});
```

### 9.2 File Validation & Security

**File: `app/Http/Requests/UploadDocumentRequest.php`**

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'template_id' => 'required|exists:templates,id',
            'document' => [
                'required',
                'file',
                'mimes:docx,pdf',
                'max:10240', // 10MB
                function ($attribute, $value, $fail) {
                    // Check magic bytes untuk prevent fake extension
                    $mime = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $value->path());
                    $allowed = [
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/pdf'
                    ];

                    if (!in_array($mime, $allowed)) {
                        $fail('File type tidak valid.');
                    }
                },
            ],
        ];
    }
}
```

### 9.3 Database Optimization

**Add Indexes:**

```powershell
php artisan make:migration add_indexes_to_tables
```

```php
public function up()
{
    Schema::table('templates', function (Blueprint $table) {
        $table->index(['faculty_id', 'program_study_id', 'is_active']);
    });

    Schema::table('document_checks', function (Blueprint $table) {
        $table->index(['user_id', 'check_status']);
        $table->index('created_at');
    });
}
```

### 9.4 Caching

**Template List Caching:**

```php
public function index(Request $request)
{
    $user = $request->user();
    $cacheKey = "templates.faculty.{$user->faculty_id}.prodi.{$user->program_study_id}";

    $templates = Cache::remember($cacheKey, 3600, function () use ($user) {
        return Template::where('is_active', true)
            ->where('faculty_id', $user->faculty_id)
            ->where('program_study_id', $user->program_study_id)
            ->with(['faculty', 'programStudy'])
            ->get();
    });

    return response()->json($templates);
}
```

---

## 📌 FASE 10: Deployment

### 10.1 Pre-Deployment Checklist

```powershell
# Run tests
php artisan test

# Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Build frontend
npm run build
```

### 10.2 Environment Setup

**Production `.env`:**

```env
APP_NAME="Template Document Checker"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=template_production
DB_USERNAME=your_user
DB_PASSWORD=your_password

QUEUE_CONNECTION=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

OPENAI_API_KEY=your_production_api_key

FILESYSTEM_DISK=public
# atau untuk S3:
# FILESYSTEM_DISK=s3
# AWS_ACCESS_KEY_ID=
# AWS_SECRET_ACCESS_KEY=
# AWS_DEFAULT_REGION=
# AWS_BUCKET=

SESSION_DRIVER=redis
CACHE_DRIVER=redis
```

### 10.3 Server Requirements

**Minimum Requirements:**

-   PHP >= 8.1
-   MySQL >= 8.0 / PostgreSQL >= 13
-   Redis (untuk cache & queue)
-   Composer
-   Node.js & NPM

**Recommended:**

-   2 CPU Cores
-   4GB RAM
-   20GB Storage (SSD)

### 10.4 Nginx Configuration

**File: `/etc/nginx/sites-available/template-app`**

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name yourdomain.com;
    root /var/www/template_in/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### 10.5 SSL Setup

```bash
# Install Certbot
sudo apt install certbot python3-certbot-nginx

# Get SSL Certificate
sudo certbot --nginx -d yourdomain.com
```

### 10.6 Deployment Script

**File: `deploy.sh`**

```bash
#!/bin/bash

echo "🚀 Starting deployment..."

# Pull latest code
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader
npm install
npm run build

# Run migrations
php artisan migrate --force

# Clear & cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Restart services
php artisan queue:restart
sudo systemctl restart php8.1-fpm
sudo systemctl reload nginx

echo "✅ Deployment completed!"
```

---

## 📊 Database Schema Summary

```sql
-- faculties
id, name, timestamps

-- program_studies
id, faculty_id, name, timestamps

-- users
id, name, email, password, role, faculty_id, program_study_id, timestamps

-- templates
id, name, type, faculty_id, program_study_id, rules, description,
file_path, is_active, download_count, timestamps

-- document_checks
id, user_id, template_id, original_filename, file_path, file_type, file_size,
ai_result, violations, suggestions, compliance_score, check_status, timestamps
```

---

## 🔧 Troubleshooting

### Common Issues

**1. Queue not processing:**

```powershell
# Check queue worker
php artisan queue:work --once

# Clear failed jobs
php artisan queue:flush
```

**2. Storage symlink issue:**

```powershell
php artisan storage:link
```

**3. Permission issues:**

```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

**4. OpenAI API errors:**

-   Check API key validity
-   Check API rate limits
-   Verify account balance

---

## 📚 Documentation Links

-   [Laravel Documentation](https://laravel.com/docs)
-   [PHPWord Documentation](https://phpword.readthedocs.io/)
-   [OpenAI API Reference](https://platform.openai.com/docs)
-   [React Documentation](https://react.dev/)
-   [TailwindCSS Documentation](https://tailwindcss.com/)

---

## 🎯 Quick Commands Reference

```powershell
# Development
php artisan serve
npm run dev
php artisan queue:work

# Database
php artisan migrate
php artisan db:seed
php artisan migrate:fresh --seed

# Testing
php artisan test
php artisan test --coverage

# Production
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build

# Queue
php artisan queue:work
php artisan queue:restart
php artisan queue:failed
php artisan queue:retry all
```

---

## ✅ Progress Tracker

### Database & Models

-   [x] Create migrations
-   [x] Create models
-   [ ] Create seeders
-   [ ] Run migrations & seeders

### Backend

-   [ ] Create controllers
-   [ ] Setup routes
-   [ ] Create middleware
-   [ ] Create services
-   [ ] Create jobs

### AI Integration

-   [ ] Install OpenAI client
-   [ ] Create DocumentAnalyzerService
-   [ ] Test AI integration

### Frontend

-   [ ] Setup React/Vue
-   [ ] Create admin dashboard
-   [ ] Create student dashboard
-   [ ] Create components

### Testing

-   [ ] Write unit tests
-   [ ] Write feature tests
-   [ ] Run all tests

### Deployment

-   [ ] Setup production server
-   [ ] Configure Nginx
-   [ ] Setup SSL
-   [ ] Deploy application

---

**Last Updated:** October 14, 2025
**Version:** 1.0.0
**Project:** Template Document Checker with AI
