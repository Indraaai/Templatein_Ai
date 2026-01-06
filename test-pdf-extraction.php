<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\DocumentCheck;
use App\Services\GroqService;
use Illuminate\Support\Facades\Storage;

echo "\n=== TESTING PDF EXTRACTION ===\n\n";

// Get the failed document
$doc = DocumentCheck::find(2);

if (!$doc) {
    echo "Document not found!\n";
    exit(1);
}

echo "Document ID: {$doc->id}\n";
echo "File: {$doc->original_filename}\n";
echo "Type: {$doc->file_type}\n";
echo "Status: {$doc->check_status}\n\n";

$filePath = Storage::disk('public')->path($doc->file_path);

echo "Full path: {$filePath}\n";
echo "File exists: " . (file_exists($filePath) ? 'YES' : 'NO') . "\n";

if (!file_exists($filePath)) {
    echo "ERROR: File not found!\n";
    exit(1);
}

echo "File size: " . number_format(filesize($filePath)) . " bytes\n\n";

echo "--- Testing PDF Parser Library ---\n";
echo "Class exists: " . (class_exists('\Smalot\PdfParser\Parser') ? 'YES' : 'NO') . "\n\n";

echo "--- Attempting extraction ---\n";
$service = new GroqService();
$text = $service->extractTextFromPdf($filePath);

if ($text) {
    echo "SUCCESS!\n";
    echo "Extracted text length: " . strlen($text) . " characters\n";
    echo "First 200 chars:\n";
    echo substr($text, 0, 200) . "...\n";
} else {
    echo "FAILED to extract text!\n";
    echo "\nCheck storage/logs/laravel.log for details\n";
}

echo "\n=== TEST COMPLETE ===\n";
