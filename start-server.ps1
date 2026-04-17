# Start Development Server untuk BENGKEL Project (PowerShell)
# Script ini menjalankan Laravel development server tanpa Laragon GUI

Write-Host ""
Write-Host "========================================"
Write-Host "BENGKEL - Local Development Server"
Write-Host "========================================"
Write-Host ""

# Setup PATH untuk PHP dari Laragon
$laraagonPhp = "C:\laragon\bin\php\php-8.2.12-Win32-vs16-x64\bin"
$env:PATH = "$laraagonPhp;$env:PATH"

# Verify PHP
Write-Host "[1/3] Verifying PHP installation..."
try {
    php --version
} catch {
    Write-Host "ERROR: PHP tidak ditemukan!"
    Write-Host "Pastikan Laragon terinstall dengan benar."
    exit 1
}

# Change directory
Write-Host ""
Write-Host "[2/3] Changing to project directory..."
Set-Location "C:\laragon\www\BENGKEL"
if (-not (Test-Path "artisan")) {
    Write-Host "ERROR: Direktori project tidak ditemukan!"
    exit 1
}
Write-Host "✓ Project directory set"

# Clear cache
Write-Host ""
Write-Host "[3/3] Clearing application cache..."
php artisan config:clear 2>$null
php artisan cache:clear 2>$null
Write-Host "✓ Cache cleared"

# Start server
Write-Host ""
Write-Host "========================================"
Write-Host "Server running at: http://localhost:8000"
Write-Host "Database: MySQL (127.0.0.1:3306)"
Write-Host "Press CTRL+C to stop server"
Write-Host "========================================"
Write-Host ""

php artisan serve --host=localhost --port=8000
