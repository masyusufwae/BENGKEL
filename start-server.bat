@echo off
REM Start Development Server untuk BENGKEL Project
REM Script ini menjalankan Laravel development server tanpa Laragon GUI

echo.
echo ========================================
echo BENGKEL - Local Development Server
echo ========================================
echo.

REM Setup PATH untuk PHP dari Laragon
set "LARAGON_PHP=C:\laragon\bin\php\php-8.2.12-Win32-vs16-x64\bin"
set "PATH=%LARAGON_PHP%;%PATH%"

REM Verify PHP
echo [1/3] Verifying PHP installation...
php --version
if errorlevel 1 (
    echo ERROR: PHP tidak ditemukan!
    echo Pastikan Laragon terinstall dengan benar.
    pause
    exit /b 1
)

REM Change directory
cd /d C:\laragon\www\BENGKEL
if errorlevel 1 (
    echo ERROR: Direktori project tidak ditemukan!
    pause
    exit /b 1
)

REM Clear old cache
echo.
echo [2/3] Clearing application cache...
php artisan config:clear
php artisan cache:clear
if errorlevel 1 (
    echo WARNING: Cache clear gagal, lanjut...
)

REM Start server
echo.
echo [3/3] Starting Laravel development server...
echo.
echo ========================================
echo Server running at: http://localhost:8000
echo Press CTRL+C to stop server
echo ========================================
echo.

php artisan serve --host=localhost --port=8000

pause
