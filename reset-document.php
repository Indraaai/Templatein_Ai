<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\DocumentCheck;

echo "\n=== RESET DOCUMENT FOR RECHECK ===\n\n";

$doc = DocumentCheck::find(2);

if (!$doc) {
    echo "Document not found!\n";
    exit(1);
}

echo "Resetting document ID: {$doc->id}\n";
echo "File: {$doc->original_filename}\n";

$doc->update([
    'check_status' => 'pending',
    'ai_feedback' => null,
    'ai_result' => null,
    'ai_score' => null,
    'violations' => null,
    'suggestions' => null,
]);

echo "\n✓ Document reset successfully!\n";
echo "\nNow visit: http://127.0.0.1:8000/student/documents/2\n";
echo "And click 'Periksa Ulang' button to trigger AI analysis.\n\n";
