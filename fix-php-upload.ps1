# PowerShell Script untuk memperbaiki konfigurasi PHP upload di Laragon
# Run as Administrator untuk hasil terbaik

Write-Host "===============================================" -ForegroundColor Cyan
Write-Host "  FIX PHP UPLOAD CONFIGURATION FOR LARAGON" -ForegroundColor Cyan
Write-Host "===============================================`n" -ForegroundColor Cyan

# Detect PHP path
$phpPath = "C:\laragon\bin\php"

if (-not (Test-Path $phpPath)) {
    Write-Host "ERROR: Laragon PHP directory not found at $phpPath" -ForegroundColor Red
    Write-Host "Please check your Laragon installation path" -ForegroundColor Yellow
    pause
    exit 1
}

# Find active PHP version
Write-Host "Detecting PHP version..." -ForegroundColor Yellow
$phpVersions = Get-ChildItem -Path $phpPath -Directory -Filter "php-*" | Sort-Object Name -Descending
$latestPhp = $phpVersions[0]

if (-not $latestPhp) {
    Write-Host "ERROR: No PHP installation found in $phpPath" -ForegroundColor Red
    pause
    exit 1
}

$phpIni = Join-Path $latestPhp.FullName "php.ini"
Write-Host "PHP Installation: $($latestPhp.FullName)" -ForegroundColor Green
Write-Host "PHP INI File: $phpIni`n" -ForegroundColor Green

if (-not (Test-Path $phpIni)) {
    Write-Host "ERROR: php.ini not found at $phpIni" -ForegroundColor Red
    pause
    exit 1
}

# Create backup
Write-Host "Creating backup of php.ini..." -ForegroundColor Yellow
$backupName = "php.ini.backup." + (Get-Date -Format "yyyyMMdd_HHmmss")
$backupPath = Join-Path $latestPhp.FullName $backupName
Copy-Item $phpIni $backupPath
Write-Host "Backup created: $backupPath`n" -ForegroundColor Green

# Read current content
Write-Host "Updating PHP configuration..." -ForegroundColor Yellow
$content = Get-Content $phpIni -Raw

# Update values
$updates = @{
    'upload_max_filesize' = '15M'
    'post_max_size' = '20M'
    'max_execution_time' = '300'
    'max_input_time' = '300'
    'memory_limit' = '256M'
}

foreach ($key in $updates.Keys) {
    $value = $updates[$key]
    # Try to replace existing value
    $pattern = "(?m)^\s*$key\s*=\s*.+$"
    if ($content -match $pattern) {
        $content = $content -replace $pattern, "$key = $value"
        Write-Host "  Updated: $key = $value" -ForegroundColor Green
    } else {
        Write-Host "  Warning: Could not find $key in php.ini" -ForegroundColor Yellow
    }
}

# Write back to file
Set-Content $phpIni -Value $content

Write-Host "`nConfiguration updated successfully!`n" -ForegroundColor Green

# Verify changes
Write-Host "New values:" -ForegroundColor Cyan
& php -r "echo 'upload_max_filesize = ' . ini_get('upload_max_filesize') . PHP_EOL;"
& php -r "echo 'post_max_size = ' . ini_get('post_max_size') . PHP_EOL;"
& php -r "echo 'max_execution_time = ' . ini_get('max_execution_time') . PHP_EOL;"
& php -r "echo 'max_input_time = ' . ini_get('max_input_time') . PHP_EOL;"
& php -r "echo 'memory_limit = ' . ini_get('memory_limit') . PHP_EOL;"

Write-Host "`n===============================================" -ForegroundColor Cyan
Write-Host "  NEXT STEPS" -ForegroundColor Cyan
Write-Host "===============================================" -ForegroundColor Cyan
Write-Host "1. Restart Apache/Nginx through Laragon" -ForegroundColor Yellow
Write-Host "2. Run: php check-upload-config.php" -ForegroundColor Yellow
Write-Host "3. Test document upload in the application`n" -ForegroundColor Yellow

$response = Read-Host "Would you like to open Laragon now? (Y/N)"
if ($response -eq 'Y' -or $response -eq 'y') {
    $laraPath = "C:\laragon\laragon.exe"
    if (Test-Path $laraPath) {
        Start-Process $laraPath
    } else {
        Write-Host "Laragon executable not found at $laraPath" -ForegroundColor Yellow
    }
}

Write-Host "`nDone! Press any key to exit..." -ForegroundColor Green
$null = $Host.UI.RawUI.ReadKey('NoEcho,IncludeKeyDown')
