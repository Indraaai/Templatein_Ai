<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Services\StructureExtractor;

class GroqService
{
    protected $apiKey;
    protected $model;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('groq.api_key');
        $this->model = config('groq.model');
        $this->baseUrl = config('groq.base_url');
    }

    /**
     * Analyze document content using Groq AI
     */
    public function analyzeDocument(string $content, array $templateRules = [], string $templateName = '')
    {
        try {
            // Limit content length to avoid token limit (roughly 4 chars = 1 token)
            // Groq limit is 12000 tokens for llama-3.3-70b-versatile
            // We'll use max 30000 chars (~7500 tokens) to leave room for prompt
            $maxContentChars = 30000;

            if (strlen($content) > $maxContentChars) {
                Log::warning('Document content too long, truncating', [
                    'original_length' => strlen($content),
                    'truncated_to' => $maxContentChars
                ]);

                // Take beginning (more important for structure analysis)
                $content = substr($content, 0, $maxContentChars);
                $content .= "\n\n[... dokumen dipotong karena terlalu panjang, analisis fokus pada bagian awal ...]";
            }

            $prompt = $this->buildDocumentAnalysisPrompt($content, $templateRules, $templateName);

            $response = Http::timeout(config('groq.timeout'))
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post($this->baseUrl . '/chat/completions', [
                    'model' => $this->model,
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'Anda adalah asisten AI expert dalam menganalisis dokumen akademik mahasiswa Indonesia. Berikan analisis yang detail, konstruktif, dan dalam bahasa Indonesia yang baik.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'temperature' => config('groq.temperature'),
                    'max_tokens' => config('groq.max_tokens'),
                    'top_p' => 1,
                    'stream' => false,
                ]);

            if ($response->successful()) {
                return $this->parseResponse($response->json());
            }

            Log::error('Groq API Error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Groq Service Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return null;
        }
    }

    /**
     * Build comprehensive prompt for document analysis
     */
    protected function buildDocumentAnalysisPrompt(string $content, array $templateRules, string $templateName)
    {
        $rulesText = $this->formatRules($templateRules);

        return <<<PROMPT
Anda adalah AI Expert Validator untuk dokumen akademik di Universitas.

TEMPLATE YANG HARUS DIIKUTI: "{$templateName}"

ATURAN TEMPLATE (WAJIB):
{$rulesText}

DOKUMEN MAHASISWA YANG DIUPLOAD:
{$content}

═══════════════════════════════════════════════════
TUGAS ANDA - FOKUS UTAMA: VALIDASI STRUKTUR DOKUMEN
═══════════════════════════════════════════════════

⚠️ PENTING: HANYA ANALISIS STRUKTUR, JANGAN BACA ISI KONTEN!

🎯 FOKUS PENGECEKAN STRUKTUR (100% skor):

1. BAGIAN AWAL DOKUMEN (30%):
   ✓ Apakah ada COVER/HALAMAN JUDUL?
   ✓ Apakah ada LEMBAR PENGESAHAN?
   ✓ Apakah ada KATA PENGANTAR?
   ✓ Apakah ada DAFTAR ISI?
   ✓ Apakah urutan halaman awal SESUAI template?

2. STRUKTUR BAB DAN SUBBAB (50%):
   ✓ Apakah semua BAB yang diwajibkan ADA? (BAB I, II, III, dst)
   ✓ Apakah JUDUL BAB sesuai template? (PENDAHULUAN, TINJAUAN PUSTAKA, dll)
   ✓ Apakah SUBBAB lengkap? (1.1, 1.2, 2.1, 2.2, dst)
   ✓ Apakah NUMBERING SYSTEM konsisten? (1.1.1, 1.1.2 atau a, b, c)
   ✓ Apakah HIERARKI heading jelas? (Heading 1, 2, 3)

3. BAGIAN AKHIR DOKUMEN (20%):
   ✓ Apakah ada BAB PENUTUP/KESIMPULAN?
   ✓ Apakah ada DAFTAR PUSTAKA?
   ✓ Apakah ada LAMPIRAN (jika diperlukan)?
   ✓ Apakah urutan bagian akhir SESUAI template?

CARA ANALISIS:
- IDENTIFIKASI heading berdasarkan: huruf kapital semua, ukuran font besar, posisi di awal paragraf
- EKSTRAK semua BAB (contoh: "BAB I", "BAB II", "CHAPTER 1")
- EKSTRAK semua SUBBAB (contoh: "1.1", "2.1.1", "A.", "a)")
- HITUNG jumlah bab dan bandingkan dengan template
- CEK urutan struktur dari awal sampai akhir

JANGAN:
❌ Membaca isi paragraf/konten
❌ Menganalisis tata bahasa atau ejaan
❌ Mengecek kualitas penulisan
❌ Membaca abstrak atau isi bab secara detail

   Contoh yang HARUS ADA (sesuai template):
   - Cover/Halaman Judul
   - Lembar Pengesahan
   - Abstrak (Bahasa Indonesia & Inggris)
   - Kata Pengantar
   - Daftar Isi, Tabel, Gambar
   - BAB I PENDAHULUAN (1.1 Latar Belakang, 1.2 Rumusan Masalah, dst)
   - BAB II TINJAUAN PUSTAKA
   - BAB III METODOLOGI
   - BAB IV HASIL DAN PEMBAHASAN
   - BAB V PENUTUP (5.1 Kesimpulan, 5.2 Saran)
   - DAFTAR PUSTAKA
   - LAMPIRAN

2. KELENGKAPAN KONTEN TIAP SECTION (30% dari total skor):
   ✓ Apakah setiap section punya KONTEN yang cukup?
   ✓ Apakah abstrak memenuhi minimal kata (150-250 kata)?
   ✓ Apakah BAB I punya semua sub-bab wajib?
   ✓ Apakah Daftar Pustaka memenuhi minimal jumlah (10-15 referensi)?
   ✓ Apakah ada tabel/gambar jika diwajibkan?

3. FORMAT PENULISAN SESUAI TEMPLATE (20% dari total skor):
   ✓ Font: Times New Roman 12pt (body), 14pt (heading)
   ✓ Spasi: 1.5 atau 2.0 sesuai aturan
   ✓ Margin: 4cm (kiri), 3cm (kanan, atas, bawah)
   ✓ Alignment: Justify untuk paragraf
   ✓ Indentasi: 1.25 cm untuk paragraf baru

4. TATA BAHASA & KONSISTENSI (10% dari total skor):
   ✓ Bahasa formal dan baku
   ✓ Ejaan sesuai EYD/PUEBI
   ✓ Konsistensi istilah teknis
   ✓ Tidak ada typo major

═══════════════════════════════════════════════════
CARA PENILAIAN:
═══════════════════════════════════════════════════

- Skor 90-100: EXCELLENT - Sangat sesuai template, minimal revisi
- Skor 80-89:  GOOD - Sesuai template, ada revisi minor
- Skor 70-79:  FAIR - Cukup sesuai, perlu perbaikan beberapa bagian
- Skor <70:    POOR - Banyak ketidaksesuaian, perlu revisi major

FOKUS UTAMA: Cek apakah dokumen MENGIKUTI STRUKTUR TEMPLATE yang sudah ditetapkan oleh Program Studi!

BERIKAN HASIL DALAM FORMAT JSON BERIKUT (HANYA JSON, TANPA PENJELASAN LAIN):
{
  "overall_score": 85,
  "status": "approved",
  "analysis": {
    "format": {
      "score": 90,
      "issues": [
        "Margin kiri 2.5cm, seharusnya 3cm",
        "Font heading inkonsisten antara Bab 1 dan 2"
      ],
      "suggestions": [
        "Sesuaikan margin kiri menjadi 3cm pada semua halaman",
        "Gunakan Times New Roman 14pt Bold untuk semua heading Bab"
      ]
    },
    "content": {
      "score": 85,
      "issues": [
        "Abstrak hanya 120 kata, minimal 150 kata",
        "Daftar Pustaka kurang dari 10 referensi"
      ],
      "suggestions": [
        "Perluas abstrak dengan menambahkan ringkasan hasil penelitian",
        "Tambahkan minimal 5 referensi jurnal terbaru (2020-2024)"
      ]
    },
    "grammar": {
      "score": 88,
      "issues": [
        "Beberapa typo: 'peneltian' → 'penelitian'",
        "Inkonsistensi penggunaan kata 'data' vs 'datum'"
      ],
      "suggestions": [
        "Gunakan spell checker untuk mengoreksi typo",
        "Konsisten gunakan kata 'data' untuk jamak dan tunggal"
      ]
    },
    "compliance": {
      "score": 80,
      "issues": [
        "Tidak ada Halaman Persetujuan",
        "Nomor halaman dimulai dari cover (seharusnya dari Bab 1)"
      ],
      "suggestions": [
        "Tambahkan Halaman Persetujuan setelah cover",
        "Mulai penomoran dari Bab 1 dengan angka Arab"
      ]
    }
  },
  "violations": [
    {
      "type": "format",
      "severity": "medium",
      "location": "Semua halaman",
      "issue": "Margin kiri tidak sesuai standar",
      "expected": "3cm",
      "found": "2.5cm"
    },
    {
      "type": "content",
      "severity": "high",
      "location": "Halaman Awal",
      "issue": "Tidak ada Halaman Persetujuan",
      "expected": "Ada setelah cover",
      "found": "Tidak ada"
    }
  ],
  "suggestions": [
    "Sesuaikan margin seluruh dokumen: kiri 3cm, kanan 2.5cm, atas 3cm, bawah 2.5cm",
    "Tambahkan Halaman Persetujuan dengan format standar universitas",
    "Perbaiki semua typo yang ditemukan",
    "Perluas abstrak menjadi minimal 150 kata",
    "Tambahkan lebih banyak referensi jurnal terbaru",
    "Konsistenkan penggunaan font untuk heading",
    "Perbaiki sistem penomoran halaman"
  ],
  "summary": "Dokumen sudah cukup baik dengan skor 85/100. Terdapat beberapa perbaikan penting terkait format margin, kelengkapan halaman, dan penambahan referensi. Secara keseluruhan struktur dokumen sudah mengikuti template dengan baik.",
  "ai_feedback": "Dokumen Anda menunjukkan pemahaman yang baik terhadap struktur penulisan akademik. Kekuatan utama terletak pada konten yang informatif dan tata bahasa yang cukup baik. Namun, perhatikan detail-detail teknis seperti margin, kelengkapan halaman wajib, dan jumlah referensi. Dengan perbaikan yang disarankan, dokumen ini akan memenuhi standar dengan sangat baik."
}

KETENTUAN STATUS:
- "approved": skor >= 75 (dokumen bagus, siap digunakan dengan sedikit perbaikan)
- "need_revision": skor 50-74 (perlu perbaikan signifikan)
- "rejected": skor < 50 (banyak masalah, perlu revisi besar)

PENTING: Berikan HANYA JSON, tanpa markdown, tanpa penjelasan tambahan.
PROMPT;
    }

    /**
     * Format template rules into readable text
     */
    protected function formatRules(array $rules)
    {
        if (empty($rules)) {
            return "Tidak ada aturan khusus. Gunakan standar penulisan akademik umum.";
        }

        $formatted = [];
        foreach ($rules as $key => $value) {
            if (is_array($value)) {
                $formatted[] = "- {$key}:";
                foreach ($value as $subKey => $subValue) {
                    $formatted[] = "  * {$subKey}: {$subValue}";
                }
            } else {
                $formatted[] = "- {$key}: {$value}";
            }
        }

        return implode("\n", $formatted);
    }

    /**
     * Parse Groq API response
     */
    protected function parseResponse(array $response)
    {
        if (isset($response['choices'][0]['message']['content'])) {
            $text = $response['choices'][0]['message']['content'];

            // Remove markdown code blocks if present
            $text = preg_replace('/```json\s*(.*?)\s*```/s', '$1', $text);
            $text = preg_replace('/```\s*(.*?)\s*```/s', '$1', $text);
            $text = trim($text);

            // Try to decode JSON
            $result = json_decode($text, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                return $result;
            }

            // Log parsing error
            Log::error('JSON Parse Error from Groq', [
                'text' => $text,
                'error' => json_last_error_msg(),
            ]);
        }

        return null;
    }

    /**
     * Extract text from PDF file - STRUCTURE ONLY
     */
    public function extractTextFromPdf(string $filePath)
    {
        try {
            if (!file_exists($filePath)) {
                Log::error('PDF file not found', ['file' => $filePath]);
                return null;
            }

            if (!class_exists('\Smalot\PdfParser\Parser')) {
                Log::error('PDF Parser class not found. Run: composer require smalot/pdfparser');
                return null;
            }

            $parser = new \Smalot\PdfParser\Parser();
            $pdf = $parser->parseFile($filePath);
            $text = $pdf->getText();

            // Extract STRUCTURE only (headings, titles, chapter markers)
            $text = StructureExtractor::extractStructureOnly($text);

            // Keep structure formatting (don't collapse whitespace here)
            $text = preg_replace('/\s{3,}/', ' ', $text);
            $text = trim($text);

            if (empty($text)) {
                Log::warning('PDF extracted but text is empty', ['file' => $filePath]);
                return null;
            }

            Log::info('PDF structure extracted', [
                'file' => basename($filePath),
                'length' => strlen($text)
            ]);

            return $text;
        } catch (\Exception $e) {
            Log::error('PDF Extraction Error', [
                'file' => $filePath,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Extract text from DOCX file - STRUCTURE ONLY
     */
    public function extractTextFromDocx(string $filePath)
    {
        try {
            if (!file_exists($filePath)) {
                Log::error('DOCX file not found', ['file' => $filePath]);
                return null;
            }

            $zip = new \ZipArchive();
            $text = '';

            if ($zip->open($filePath) === true) {
                $xml = $zip->getFromName('word/document.xml');
                if ($xml) {
                    $dom = new \DOMDocument();
                    $dom->loadXML($xml);
                    $text = $dom->textContent;
                } else {
                    Log::warning('Could not find word/document.xml in DOCX', ['file' => $filePath]);
                }
                $zip->close();
            } else {
                Log::error('Failed to open DOCX as ZIP', ['file' => $filePath]);
                return null;
            }

            // Extract STRUCTURE only (headings, titles, chapter markers)
            $text = StructureExtractor::extractStructureOnly($text);

            // Keep structure formatting (don't collapse whitespace here)
            $text = preg_replace('/\s{3,}/', ' ', $text);
            $text = trim($text);

            if (empty($text)) {
                Log::warning('DOCX extracted but text is empty', ['file' => $filePath]);
                return null;
            }

            Log::info('DOCX structure extracted', [
                'file' => basename($filePath),
                'length' => strlen($text)
            ]);

            return $text;
        } catch (\Exception $e) {
            Log::error('DOCX Extraction Error', [
                'file' => $filePath,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Generate corrected document suggestions
     */
    public function generateCorrectionSuggestions(array $analysisResult)
    {
        $suggestions = $analysisResult['suggestions'] ?? [];
        $violations = $analysisResult['violations'] ?? [];

        $correctionText = "SARAN PERBAIKAN DOKUMEN\n\n";
        $correctionText .= "Berdasarkan analisis AI, berikut adalah perbaikan yang perlu dilakukan:\n\n";

        if (!empty($violations)) {
            $correctionText .= "PELANGGARAN YANG DITEMUKAN:\n";
            foreach ($violations as $index => $violation) {
                $num = $index + 1;
                $correctionText .= "{$num}. [{$violation['severity']}] {$violation['issue']}\n";
                $correctionText .= "   Lokasi: {$violation['location']}\n";
                $correctionText .= "   Diharapkan: {$violation['expected']}\n";
                $correctionText .= "   Ditemukan: {$violation['found']}\n\n";
            }
        }

        if (!empty($suggestions)) {
            $correctionText .= "\nSARAN PERBAIKAN:\n";
            foreach ($suggestions as $index => $suggestion) {
                $num = $index + 1;
                $correctionText .= "{$num}. {$suggestion}\n";
            }
        }

        return $correctionText;
    }

    /**
     * Check model availability
     */
    public function testConnection()
    {
        try {
            $response = Http::timeout(10)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post($this->baseUrl . '/chat/completions', [
                    'model' => $this->model,
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => 'Test connection. Reply with: OK'
                        ]
                    ],
                    'max_tokens' => 10,
                ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Groq Connection Test Failed', ['error' => $e->getMessage()]);
            return false;
        }
    }
}
