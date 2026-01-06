@echo off
REM Script untuk memperbaiki konfigurasi PHP upload di Laragon
REM Run as Administrator untuk hasil terbaik

echo ===============================================
echo   FIX PHP UPLOAD CONFIGURATION FOR LARAGON
echo ===============================================
echo.

REM Detect PHP path
set PHP_PATH=C:\laragon\bin\php
if not exist "%PHP_PATH%" (
    echo ERROR: Laragon PHP directory not found at %PHP_PATH%
    echo Please check your Laragon installation path
    pause
    exit /b 1
)

REM Find active PHP version
echo Detecting PHP version...
for /d %%i in ("%PHP_PATH%\php-*") do (
    set LATEST_PHP=%%i
)

if not defined LATEST_PHP (
    echo ERROR: No PHP installation found in %PHP_PATH%
    pause
    exit /b 1
)

set PHP_INI=%LATEST_PHP%\php.ini
echo PHP Installation: %LATEST_PHP%
echo PHP INI File: %PHP_INI%
echo.

if not exist "%PHP_INI%" (
    echo ERROR: php.ini not found at %PHP_INI%
    pause
    exit /b 1
)

echo Creating backup of php.ini...
copy "%PHP_INI%" "%PHP_INI%.backup.%date:~-4,4%%date:~-10,2%%date:~-7,2%_%time:~0,2%%time:~3,2%%time:~6,2%"
echo Backup created: %PHP_INI%.backup.*
echo.

echo Updating PHP configuration...

REM Use PowerShell to update php.ini
powershell -Command "$content = Get-Content '%PHP_INI%' -Raw; $content = $content -replace 'upload_max_filesize\s*=\s*\d+M', 'upload_max_filesize = 15M'; $content = $content -replace 'post_max_size\s*=\s*\d+M', 'post_max_size = 20M'; $content = $content -replace 'max_execution_time\s*=\s*\d+', 'max_execution_time = 300'; $content = $content -replace 'max_input_time\s*=\s*-?\d+', 'max_input_time = 300'; $content = $content -replace 'memory_limit\s*=\s*\d+M', 'memory_limit = 256M'; Set-Content '%PHP_INI%' -Value $content"

echo.
echo Configuration updated successfully!
echo.
echo New values:
php -r "echo 'upload_max_filesize = ' . ini_get('upload_max_filesize') . PHP_EOL;"
php -r "echo 'post_max_size = ' . ini_get('post_max_size') . PHP_EOL;"
php -r "echo 'max_execution_time = ' . ini_get('max_execution_time') . PHP_EOL;"
php -r "echo 'max_input_time = ' . ini_get('max_input_time') . PHP_EOL;"
php -r "echo 'memory_limit = ' . ini_get('memory_limit') . PHP_EOL;"
echo.

echo ===============================================
echo   NEXT STEPS
echo ===============================================
echo 1. Restart Apache/Nginx through Laragon
echo 2. Run: php check-upload-config.php
echo 3. Test document upload in the application
echo.
echo Press any key to open Laragon...
pause >nul

REM Try to open Laragon
start "" "C:\laragon\laragon.exe"

exit /b 0
