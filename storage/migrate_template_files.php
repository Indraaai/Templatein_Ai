<?php

/**
 * Migration Script: Move Template Files from Old to New Location
 *
 * Run this with: php artisan tinker < storage/migrate_template_files.php
 * Or create as Laravel command
 */

use App\Models\Template;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

echo "=== Template Files Migration ===\n\n";

// Old location: storage/app/templates/
// New location: storage/app/public/templates/

$oldBasePath = storage_path('app/templates');
$newBasePath = storage_path('app/public/templates');

// Create new directory if not exists
if (!is_dir($newBasePath)) {
    mkdir($newBasePath, 0755, true);
    echo "✅ Created directory: $newBasePath\n";
}

// Get all templates with template_file
$templates = Template::whereNotNull('template_file')->get();
echo "Found {$templates->count()} templates with files\n\n";

$moved = 0;
$errors = 0;
$alreadyCorrect = 0;

foreach ($templates as $template) {
    $oldPath = $oldBasePath . '/' . basename($template->template_file);
    $newPath = $newBasePath . '/' . basename($template->template_file);

    echo "Template ID: {$template->id} - {$template->name}\n";
    echo "  Old path: {$template->template_file}\n";

    // Check if file exists in old location
    if (file_exists($oldPath)) {
        // Move file
        if (copy($oldPath, $newPath)) {
            echo "  ✅ Moved to new location\n";

            // Update database path (should already be correct, just 'templates/...')
            // No need to update if path is relative
            if (str_starts_with($template->template_file, 'storage/app/')) {
                // Fix absolute path to relative
                $relativePath = 'templates/' . basename($template->template_file);
                $template->update(['template_file' => $relativePath]);
                echo "  ✅ Updated database path to: {$relativePath}\n";
            }

            // Delete old file
            unlink($oldPath);
            echo "  ✅ Deleted old file\n";

            $moved++;
        } else {
            echo "  ❌ Failed to move file\n";
            $errors++;
        }
    }
    // Check if file already in new location
    elseif (file_exists($newPath)) {
        echo "  ℹ️  Already in new location\n";
        $alreadyCorrect++;

        // Ensure database path is correct
        if (str_starts_with($template->template_file, 'storage/app/')) {
            $relativePath = 'templates/' . basename($template->template_file);
            $template->update(['template_file' => $relativePath]);
            echo "  ✅ Fixed database path to: {$relativePath}\n";
        }
    }
    // File doesn't exist in either location
    else {
        echo "  ⚠️  File not found in either location\n";
        // Set template_file to null if file is missing
        $template->update(['template_file' => null, 'is_active' => false]);
        echo "  ✅ Cleared template_file and deactivated template\n";
        $errors++;
    }

    echo "\n";
}

echo "\n=== Migration Summary ===\n";
echo "Moved: $moved files\n";
echo "Already correct: $alreadyCorrect files\n";
echo "Errors: $errors\n";

// Clean up old directory if empty
if (is_dir($oldBasePath) && count(scandir($oldBasePath)) == 2) { // only . and ..
    rmdir($oldBasePath);
    echo "\n✅ Deleted empty old directory\n";
}

echo "\n=== Migration Complete! ===\n";
echo "Next steps:\n";
echo "1. Test download feature as student\n";
echo "2. Test save template feature as admin\n";
echo "3. Verify files are in storage/app/public/templates/\n";
