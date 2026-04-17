# 🐛 Troubleshooting Guide

Solusi untuk masalah umum yang mungkin dihadapi saat development.

---

## 🚀 Server Issues

### **"Port 8000 already in use"**

**Error:**
```
Error: bind EADDRINUSE :::8000
```

**Cause:** Port 8000 sudah digunakan oleh proses lain

**Solutions:**

```bash
# Option 1: Use different port
php artisan serve --port=8001

# Option 2: Kill process using port 8000 (PowerShell)
Get-Process | Where-Object {$_.ProcessName -like "*php*"} | Stop-Process -Force

# Option 3: Find what's using port 8000 (PowerShell)
netstat -ano | findstr ":8000"
taskkill /PID <PID> /F

# Option 4: Use different port in .env
# Edit .env and change APP_URL=http://localhost:8001
```

---

### **"PHP command not found"**

**Error:**
```
'php' is not recognized as an internal or external command
```

**Cause:** PHP tidak di system PATH

**Solution 1: Manual add to PATH**

```batch
@echo off
REM Add this at top of start-server.bat
set "PATH=C:\laragon\bin\php\php-8.2.12-Win32-vs16-x64\bin;%PATH%"

php artisan serve
```

**Solution 2: Use full path**

```batch
C:\laragon\bin\php\php-8.2.12-Win32-vs16-x64\bin\php.exe artisan serve
```

**Solution 3: Global PATH setup**

```powershell
# Find your PHP version first
Get-ChildItem "C:\laragon\bin\php" -Directory

# Then add to Windows PATH (System > Advanced > Environment Variables)
# Add: C:\laragon\bin\php\php-8.2.12-Win32-vs16-x64\bin
```

---

### **"Laravel Application Crashed"**

**Error:** White screen or error 500

**Solutions:**

```bash
# 1. Clear cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# 2. Check logs
tail -f storage/logs/laravel.log

# 3. Check .env file exists
ls -la .env

# 4. Check permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

# 5. Regenerate app key
php artisan key:generate

# 6. Re-install dependencies
composer install
npm install
```

---

## 🗄️ Database Issues

### **"SQLSTATE[HY000] [2002] No connection could be made"**

**Error:** Database connection failed

**Cause:** MySQL service tidak running

**Solutions:**

```powershell
# Check if MySQL is running
netstat -ano | findstr ":3306"

# Start MySQL service
net start MySQL80

# Or via GUI: Services > MySQL80 > Start

# Or PowerShell as Admin:
Start-Service MySQL80

# Or for MariaDB:
net start MariaDB
Start-Service MariaDB
```

**Still not working?**

```bash
# 1. Check .env database config
cat .env | grep DB_

# Should be:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=bengkel
# DB_USERNAME=root
# DB_PASSWORD=

# 2. Test MySQL directly
mysql -u root -h 127.0.0.1
# If successful, you'll see: mysql>

# 3. Check if database exists
mysql -u root -e "SHOW DATABASES;"
# Should show "bengkel" in list

# 4. If database missing
mysql -u root -e "CREATE DATABASE bengkel;"
```

---

### **"Base table or view not found"**

**Error:**
```
SQLSTATE[42S02]: Table 'bengkel.work_orders' doesn't exist
```

**Cause:** Migrations haven't been run yet

**Solution:**

```bash
# Run all pending migrations
php artisan migrate

# Or reset and seed (WARNING: Clears all data)
php artisan migrate:fresh --seed

# Check migration status
php artisan migrate:status
```

---

### **"Integrity constraint violation: 1452 Cannot add or update a child row"**

**Error:** Foreign key constraint failed

**Usually happens when:**
- Trying to create work order with invalid vehicle ID
- Trying to create vehicle with invalid user ID
- Seeder data is incomplete

**Solutions:**

```bash
# 1. Re-seed the database
php artisan db:seed

# 2. Reset everything and reseed
php artisan migrate:fresh --seed

# 3. Check seeder file for issues:
cat database/seeders/DatabaseSeeder.php

# 4. Verify foreign keys exist:
mysql -u root bengkel -e "SELECT * FROM users LIMIT 5;"
mysql -u root bengkel -e "SELECT * FROM kendaraan_pelanggan LIMIT 5;"
```

---

### **"MySQL password error"**

**Error:**
```
SQLSTATE[HY000] [1045] Access denied for user 'root'@'127.0.0.1'
```

**Solutions:**

```bash
# 1. Test MySQL login
mysql -u root
# If successful, password is empty (default)

# 2. Check password in .env
cat .env | grep DB_PASSWORD
# Should be empty

# 3. If password exists, verify it:
mysql -u root -p 
# Enter password when prompted

# 4. Update .env if needed
# DB_PASSWORD=your_password_here
```

---

## 🔐 Authentication Issues

### **"Email not verified" error**

**Error:** Redirected to email verification page

**Solution:**

```bash
# Option 1: Verify email in database
mysql -u root bengkel
UPDATE users SET email_verified_at = NOW() WHERE email = 'user@example.com';

# Option 2: Use tinker to verify
php artisan tinker
>>> $user = User::first();
>>> $user->markEmailAsVerified();
>>> exit;

# Option 3: Disable email verification in config/auth.php
# Remove or comment out email_verified middleware from routes
```

---

### **"Class not found" error (User model, etc)"**

**Error:**
```
Class 'App\Models\User' not found
```

**Cause:** Autoloader not updated after file creation

**Solution:**

```bash
# Regenerate autoloader
composer dump-autoload

# Or full reinstall
rm -rf vendor
composer install
```

---

### **"Session expired" / "CSRF token mismatch"**

**Error:** Random logout or form submission fails

**Solutions:**

```bash
# 1. Clear session files
rm -rf storage/framework/sessions/*

# 2. Regenerate app key
php artisan key:generate

# 3. Check .env SESSION_DRIVER
# Should be "file" or "cookie"

# 4. Ensure @csrf in forms
# <form method="POST">
#     @csrf
#     ...
# </form>

# 5. Check session timeout in config/session.php
# 'lifetime' => 120  (minutes)
```

---

## 🎨 Frontend Issues

### **"CSS/JS not loading" / "Styles look broken"**

**Error:** Website looks unstyled, no styling

**Cause:** Assets not built or loaded

**Solutions:**

```bash
# 1. Build assets
npm run build

# 2. Or watch files in development
npm run dev
# Keep this running while developing

# 3. Clear view cache
php artisan view:clear

# 4. Check vite config
cat vite.config.js

# 5. Hard refresh browser
# Press Ctrl + Shift + R (or Cmd + Shift + R)

# 6. Check browser console for errors
# F12 > Console tab
```

---

### **"Vue component not rendering"**

**Error:** Vue data not showing on page

**Cause:** Vue app not initialized or missing component

**Solutions:**

```bash
# 1. Check if app.js is loaded
# Open browser F12 > Network > check app.js loaded

# 2. Build assets
npm run build

# 3. Check component name matches (case-sensitive)
# <div id="app"> in blade
# createApp(App) in js/app.js

# 4. Check for console errors
# F12 > Console tab
```

---

### **"Page blank / 404"**

**Error:** Page not found or blank

**Solutions:**

```bash
# 1. Check route exists
php artisan route:list | grep "customer"

# 2. Check controller method exists
grep -n "vehiclesIndex" app/Http/Controllers/CustomerController.php

# 3. Check blade view exists
ls resources/views/customer/vehicles/

# 4. Check for typos in route
cat routes/web.php | grep "customer"

# 5. Clear route cache
php artisan route:clear
```

---

## 🔄 Git Issues

### **"Git command not found"**

**Error:** `git is not recognized`

**Solution:**

```bash
# Install Git for Windows
# Download from: https://git-scm.com/download/win

# Or use PowerShell to update PATH
[Environment]::SetEnvironmentVariable("Path", "$env:Path;C:\Program Files\Git\bin", "User")

# Verify
git --version
```

---

### **"Merge conflicts"**

**Error:**
```
CONFLICT (content merge): file.php
```

**Solutions:**

```bash
# 1. View conflicts
git status
git diff file.php

# 2. Keep current version
git checkout --ours file.php

# 3. Keep their version
git checkout --theirs file.php

# 4. Or manually edit the file
# Find markers: <<<<< ===== >>>>>

# 5. After resolving
git add file.php
git commit -m "Merge: resolve conflicts"

# 6. Abort merge if too complex
git merge --abort
```

---

### **"Commits not pushed"**

**Error:** `Your branch is ahead of 'origin/main'`

**Solution:**

```bash
# Push to GitHub
git push origin main

# Or force push (WARNING: overwrites remote)
git push -f origin main

# Check status
git status
# Should say: "nothing to commit, working tree clean"
```

---

## 🧪 Testing Issues

### **"Tests fail / PHPUnit not found"**

**Error:**
```
vendor\bin\phpunit: command not found
```

**Solution:**

```bash
# 1. Install PHPUnit
composer require phpunit/phpunit --dev

# 2. Run tests
php artisan test

# 3. Run specific test
php artisan test tests/Feature/ExampleTest.php
```

---

## 📊 General Debugging

### **Enable Debug Mode**

Edit `.env`:
```env
APP_DEBUG=true
APP_ENV=local
```

Then check:
```bash
# View logs
tail -f storage/logs/laravel.log

# Or on Windows
Get-Content storage/logs/laravel.log -Tail 50 -Wait
```

---

### **Use Laravel Tinker (Interactive Shell)**

```bash
php artisan tinker

# View users
>>> User::all()

# Create user
>>> User::create(['name' => 'John', 'email' => 'john@test.com', 'password' => bcrypt('password')])

# Delete user
>>> User::find(1)->delete()

# Query database
>>> DB::table('users')->get()

# Exit
>>> exit
```

---

### **Check PHP Version Compatibility**

```bash
php --version
# Should show: PHP 8.2.12

# Check if extension installed
php -m | grep -i "mysql\|pdo"
```

---

## 🔧 Performance Issues

### **"Application is slow"**

**Solutions:**

```bash
# 1. Check query count
# Add in .env: APP_DEBUG=true
# See in bottom bar how many queries run

# 2. Clear cache
php artisan config:clear
php artisan cache:clear

# 3. Optimize autoloader
composer install --optimize-autoloader

# 4. Cache routes & config
php artisan route:cache
php artisan config:cache

# 5. Profile with Debugbar
composer require barryvdh/laravel-debugbar --dev
```

---

## 📱 Mobile Testing

### **Test on other devices**

```bash
# Start server accessible from network
php artisan serve --host=0.0.0.0 --port=8000

# Get your IP
ipconfig | findstr "IPv4"
# e.g.: 192.168.1.100

# Access from other device
# http://192.168.1.100:8000
```

---

## ⚡ Quick Fixes

| Error | Fix |
|-------|-----|
| Out of memory | `php -d memory_limit=-1 artisan migrate` |
| View cache issue | `php artisan view:clear` |
| Route not found | `php artisan route:clear` |
| Composer locked | `rm composer.lock && composer install` |
| NPM issues | `rm -rf node_modules && npm install` |
| Config not updating | `php artisan config:clear` |
| Database locked | `rm database.sqlite` (SQLite only) |

---

## 📞 Getting Help

If issue persists:

1. **Check logs:** `storage/logs/laravel.log`
2. **Search error:** Copy exact error → Google
3. **Check Laravel docs:** https://laravel.com/docs
4. **Try fresh install:** `php artisan migrate:fresh --seed`
5. **Ask on GitHub:** Create issue with full error + steps to reproduce

---

**Need help? Check the logs first! 🔍**

Last Updated: 2024-12
