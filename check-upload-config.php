#!/usr/bin/env php
<?php

/**
 * Script untuk mengecek konfigurasi upload dan troubleshooting
 *
 * Usage: php check-upload-config.php
 */

echo "\n";
echo "╔══════════════════════════════════════════════════════════════╗\n";
echo "║   UPLOAD CONFIGURATION CHECKER - Document Checking System    ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n\n";

// Color codes
$RED = "\033[31m";
$GREEN = "\033[32m";
$YELLOW = "\033[33m";
$BLUE = "\033[34m";
$RESET = "\033[0m";

function check($label, $condition, $value = '')
{
    global $GREEN, $RED, $RESET;
    $status = $condition ? "{$GREEN}✓{$RESET}" : "{$RED}✗{$RESET}";
    $statusText = $condition ? 'OK' : 'FAIL';
    echo sprintf("%-50s %s %s\n", $label, $status, $value);
    return $condition;
}

function formatBytes($bytes)
{
    if ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    }
    return $bytes . ' bytes';
}

echo "1. PHP CONFIGURATION\n";
echo str_repeat("-", 70) . "\n";

$upload_max_filesize = ini_get('upload_max_filesize');
$upload_max_bytes = ini_get_bytes('upload_max_filesize');
$post_max_size = ini_get('post_max_size');
$post_max_bytes = ini_get_bytes('post_max_size');
$max_execution_time = ini_get('max_execution_time');
$max_input_time = ini_get('max_input_time');
$memory_limit = ini_get('memory_limit');
$file_uploads = ini_get('file_uploads');

check("File uploads enabled", $file_uploads == '1');
check("upload_max_filesize", $upload_max_bytes >= 10485760, "[$upload_max_filesize] " . ($upload_max_bytes >= 10485760 ? 'Good' : 'Too small, need >= 10M'));
check("post_max_size", $post_max_bytes >= 10485760, "[$post_max_size] " . ($post_max_bytes >= 10485760 ? 'Good' : 'Too small, need >= 10M'));
check("max_execution_time", $max_execution_time >= 180, "[$max_execution_time]");
check("max_input_time", $max_input_time >= 180, "[$max_input_time]");
check("memory_limit", true, "[$memory_limit]");

echo "\n2. DIRECTORY PERMISSIONS\n";
echo str_repeat("-", 70) . "\n";

$base_path = __DIR__;
$storage_path = $base_path . DIRECTORY_SEPARATOR . 'storage';
$documents_path = $storage_path . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'documents';
$originals_path = $documents_path . DIRECTORY_SEPARATOR . 'originals';
$corrected_path = $documents_path . DIRECTORY_SEPARATOR . 'corrected';
$public_storage = $base_path . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'storage';

check("storage/ directory exists", is_dir($storage_path), $storage_path);
check("storage/ is writable", is_writable($storage_path));
check("storage/app/public exists", is_dir($storage_path . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'public'));
check("documents directory exists", is_dir($documents_path), $documents_path);
check("documents/originals exists", is_dir($originals_path));
check("documents/originals is writable", is_writable($originals_path));
check("documents/corrected exists", is_dir($corrected_path));
check("documents/corrected is writable", is_writable($corrected_path));
check("public/storage symlink exists", is_link($public_storage) || is_dir($public_storage), $public_storage);

echo "\n3. STORAGE SPACE\n";
echo str_repeat("-", 70) . "\n";

if (is_dir($storage_path)) {
    $free_space = disk_free_space($storage_path);
    $total_space = disk_total_space($storage_path);
    $used_space = $total_space - $free_space;
    $used_percent = ($total_space > 0) ? ($used_space / $total_space) * 100 : 0;

    echo sprintf("Total Space:  %s\n", formatBytes($total_space));
    echo sprintf("Used Space:   %s (%.1f%%)\n", formatBytes($used_space), $used_percent);
    echo sprintf("Free Space:   %s\n", formatBytes($free_space));
    check("Sufficient free space (> 1GB)", $free_space > 1073741824);
} else {
    echo "Storage directory not found - cannot check disk space\n";
}

echo "\n4. CONFIGURATION FILES\n";
echo str_repeat("-", 70) . "\n";

check(".htaccess exists", file_exists($base_path . '/public/.htaccess'));
check(".user.ini exists", file_exists($base_path . '/public/.user.ini'));
check("filesystems config exists", file_exists($base_path . '/config/filesystems.php'));

// Check if .htaccess has upload config
if (file_exists($base_path . '/public/.htaccess')) {
    $htaccess_content = file_get_contents($base_path . '/public/.htaccess');
    check(".htaccess has upload_max_filesize", strpos($htaccess_content, 'upload_max_filesize') !== false);
}

echo "\n5. LARAVEL CONFIGURATION\n";
echo str_repeat("-", 70) . "\n";

// Check if we can load Laravel
if (file_exists($base_path . '/vendor/autoload.php')) {
    require $base_path . '/vendor/autoload.php';

    try {
        $app = require_once $base_path . '/bootstrap/app.php';
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();

        $filesystem_disk = config('filesystems.default');
        $public_disk_root = config('filesystems.disks.public.root');

        check("Laravel loaded", true);
        check("Default filesystem disk", true, "[$filesystem_disk]");
        check("Public disk configured", !empty($public_disk_root), $public_disk_root);

        // Check database connection
        try {
            DB::connection()->getPdo();
            check("Database connection", true);
        } catch (Exception $e) {
            check("Database connection", false, $e->getMessage());
        }
    } catch (Exception $e) {
        check("Laravel loaded", false, $e->getMessage());
    }
} else {
    echo "Laravel vendor not found. Run 'composer install' first.\n";
}

echo "\n6. RECOMMENDATIONS\n";
echo str_repeat("-", 70) . "\n";

$issues = 0;

if ($upload_max_bytes < 10485760) {
    echo "{$YELLOW}⚠{$RESET}  Increase upload_max_filesize to at least 15M in php.ini\n";
    $issues++;
}

if ($post_max_bytes < 10485760) {
    echo "{$YELLOW}⚠{$RESET}  Increase post_max_size to at least 20M in php.ini\n";
    $issues++;
}

if (!is_dir($originals_path)) {
    echo "{$YELLOW}⚠{$RESET}  Create documents/originals directory: mkdir -p $originals_path\n";
    $issues++;
}

if (!is_dir($corrected_path)) {
    echo "{$YELLOW}⚠{$RESET}  Create documents/corrected directory: mkdir -p $corrected_path\n";
    $issues++;
}

if (!is_writable($storage_path)) {
    echo "{$YELLOW}⚠{$RESET}  Make storage writable: chmod -R 755 storage\n";
    $issues++;
}

if (!is_link($public_storage) && !is_dir($public_storage)) {
    echo "{$YELLOW}⚠{$RESET}  Create storage link: php artisan storage:link\n";
    $issues++;
}

if ($free_space < 1073741824) {
    echo "{$YELLOW}⚠{$RESET}  Low disk space. Consider cleaning up old files.\n";
    $issues++;
}

if ($issues === 0) {
    echo "{$GREEN}✓{$RESET} All checks passed! Upload system should work correctly.\n";
} else {
    echo "\n{$RED}Found $issues issue(s) that need attention.{$RESET}\n";
}

echo "\n";
echo "╔══════════════════════════════════════════════════════════════╗\n";
echo "║   For detailed documentation, see UPLOAD_FIX_DOCUMENTATION   ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n\n";

// Helper function to parse php ini values to bytes
function ini_get_bytes($option)
{
    $value = ini_get($option);
    $unit = strtolower(substr($value, -1));
    $value = (int)$value;

    switch ($unit) {
        case 'g':
            $value *= 1024;
        case 'm':
            $value *= 1024;
        case 'k':
            $value *= 1024;
    }

    return $value;
}
