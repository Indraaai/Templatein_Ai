<?php

namespace App\Services;

class StructureExtractor
{
    /**
     * Extract only structure elements from document text
     * (headings, chapters, sections - NOT full content)
     */
    public static function extractStructureOnly(string $text): string
    {
        $lines = explode("\n", $text);
        $structureLines = [];

        foreach ($lines as $line) {
            $line = trim($line);

            // Skip empty lines
            if (empty($line)) {
                continue;
            }

            // Keep line if it matches structure patterns:

            // 1. BAB/CHAPTER markers (BAB I, BAB II, CHAPTER 1, etc)
            if (preg_match('/^(BAB|CHAPTER|BAGIAN)\s+[IVXLCDM0-9]+/i', $line)) {
                $structureLines[] = $line;
                continue;
            }

            // 2. ALL CAPS TITLES (likely major headings)
            if (preg_match('/^[A-Z\s]{5,}$/', $line) && strlen($line) < 100) {
                $structureLines[] = $line;
                continue;
            }

            // 3. Numbered sections (1.1, 1.1.1, 2.3.4, etc)
            if (preg_match('/^\d+(\.\d+)*\.?\s+[A-Z]/', $line)) {
                $structureLines[] = $line;
                continue;
            }

            // 4. Lettered sections (A., a), I., i., etc)
            if (preg_match('/^[A-Za-z][\.\)]\s+[A-Z]/', $line)) {
                $structureLines[] = $line;
                continue;
            }

            // 5. Common document sections
            if (preg_match('/(COVER|LEMBAR PENGESAHAN|KATA PENGANTAR|ABSTRAK|ABSTRACT|DAFTAR ISI|DAFTAR TABEL|DAFTAR GAMBAR|PENDAHULUAN|TINJAUAN PUSTAKA|METODOLOGI|HASIL|PEMBAHASAN|PENUTUP|KESIMPULAN|SARAN|DAFTAR PUSTAKA|LAMPIRAN)/i', $line)) {
                $structureLines[] = $line;
                continue;
            }

            // 6. Page numbers and section markers
            if (preg_match('/^(Halaman|Page|Bab|Section)\s*:?\s*\d+/i', $line)) {
                $structureLines[] = $line;
                continue;
            }
        }

        $result = implode("\n", $structureLines);

        // Add summary info
        $summary = "=== STRUKTUR DOKUMEN YANG TERDETEKSI ===\n";
        $summary .= "Total baris struktur: " . count($structureLines) . "\n";
        $summary .= "=== DETAIL STRUKTUR ===\n\n";

        return $summary . $result;
    }
}
