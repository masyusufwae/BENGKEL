# 🚀 BENGKEL - Server Setup Tanpa Laragon GUI

Dokumentasi ini menjelaskan cara menjalankan BENGKEL project tanpa menggunakan Laragon GUI, sehingga lebih ringan dan hemat resources.

---

## ⚙️ Prasyarat

1. **Laragon** - Harus terinstall (untuk PHP, MySQL, dll)
2. **Terminal** - CMD, PowerShell, atau Git Bash
3. **MySQL Service** - Running di background

---

## 🔧 Langkah-Langkah Setup

### **Step 1: Pastikan MySQL Berjalan**

MySQL server harus running di background sebelum menjalankan Laravel.

**Opsi A: Auto-start MySQL saat boot (RECOMMENDED)**
```powershell
# Sebagai Administrator, jalankan:
sc config MySQL80 start=auto
# atau untuk MariaDB:
sc config MariaDB start=auto
```

**Opsi B: Manual start MySQL**
```cmd
# CMD (sebagai Administrator)
net start MySQL80

# Atau cari "Services" di Windows, cari MySQL, klik Start
```

**Verify MySQL Running:**
```cmd
mysql -u root -e "SELECT 1"
# Jika berhasil, akan output: 1
```

### **Step 2: Setup Database Lokal**

Run migrations dan seeders:

```bash
cd C:\laragon\www\BENGKEL

# Run migrations + seed
php artisan migrate:fresh --seed

# Atau separate commands:
php artisan migrate
php artisan db:seed
```

**Output yang diharapkan:**
```
✓ Migration complete
✓ Seeding complete
```

### **Step 3: Jalankan Development Server**

**Opsi A: Menggunakan Script Batch (Recommended untuk Windows)**

```cmd
# Double-click file ini:
C:\laragon\www\BENGKEL\start-server.bat
```

Atau dari terminal:
```cmd
C:\laragon\www\BENGKEL\start-server.bat
```

**Opsi B: Menggunakan PowerShell**

```powershell
# Set execution policy (jika diperlukan)
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser

# Run script
C:\laragon\www\BENGKEL\start-server.ps1
```

**Opsi C: Manual command**

```bash
cd C:\laragon\www\BENGKEL

# Method 1: Default port 8000
php artisan serve

# Method 2: Custom host & port
php artisan serve --host=localhost --port=8000

# Method 3: Allow external access (tidak recommended untuk production)
php artisan serve --host=0.0.0.0 --port=8000
```

### **Step 4: Akses Aplikasi**

Server akan berjalan di:
```
http://localhost:8000
```

Atau jika menggunakan host 0.0.0.0:
```
http://<computer-ip>:8000
http://127.0.0.1:8000
```

---

## 📝 Test Login

Setelah server running, gunakan akun test:

**Admin**
- Email: `admin@bengkel.com`
- Password: `password123`

**Pelanggan**
- Email: `pelanggan@bengkel.com`
- Password: `password123`

**Mekanik**
- Email: `mekanik@bengkel.com`
- Password: `password123`

---

## 🛑 Stop Server

**Dengan Script:**
- Tekan **CTRL + C** di terminal

**Manual:**
```bash
# Via PowerShell
Get-Process | Where-Object {$_.ProcessName -like "*php*"} | Stop-Process -Force

# Via CMD
taskkill /IM php.exe /F
```

---

## 🐛 Troubleshooting

### **Error: "SQLSTATE[HY000] [2002] No connection could be made"**

**Cause:** MySQL tidak running

**Solution:**
```powershell
# Start MySQL service
net start MySQL80

# Atau manual dari Services di Windows
```

### **Error: "Class 'PDOException' not found"**

**Cause:** PHP PDO extension tidak aktif

**Solution:** Edit `C:\laragon\bin\php\php-8.2.12-xxx\php.ini`
```ini
extension=pdo_mysql
```

### **Error: "Port 8000 already in use"**

**Solution:** Gunakan port lain
```bash
php artisan serve --port=8001
php artisan serve --port=9000
```

### **Error: "PHP command not found"**

**Cause:** PATH tidak setup dengan benar

**Solution:**
```batch
REM Add to start-server.bat sebelum php command:
set "PATH=C:\laragon\bin\php\php-8.2.12-Win32-vs16-x64\bin;%PATH%"
```

---

## 📊 Resource Comparison

| Aspect | Laragon GUI | Laravel Serve |
|--------|----------|---------------|
| Memory Usage | ~300+ MB | ~100 MB |
| CPU Usage | Higher (always running) | Lower (on-demand) |
| Startup Time | Slow | Fast (instant) |
| Auto-reload | No | Yes (auto-reload on file change) |
| Database | Manual start | Require manual start |
| Best For | Testing | Development |

---

## 🚀 Optimasi Lebih Lanjut

### **1. Use Queue Worker untuk Background Jobs**

```bash
# Terminal baru
php artisan queue:work

# Atau
php artisan queue:work --timeout=300
```

### **2. Enable File Watcher untuk Auto-reload**

Script sudah built-in di Laravel serve, akan auto-reload saat ada file changes.

### **3. Use Composer Autoload Optimization**

```bash
composer install --optimize-autoloader --no-dev
```

### **4. Cache Config & Routes**

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 📋 Daily Workflow

### **Setiap kali PC startup:**

```bash
# 1. Start MySQL
net start MySQL80

# 2. Navigate to project
cd C:\laragon\www\BENGKEL

# 3. Pull latest code (jika ada)
git pull origin main

# 4. Install dependencies (jika ada changes)
composer install
npm install

# 5. Run migrations (jika ada migration baru)
php artisan migrate

# 6. Start server
php artisan serve
```

### **Atau create batch file untuk automation:**

```batch
@echo off
net start MySQL80
cd /d C:\laragon\www\BENGKEL
git pull origin main
composer install
php artisan migrate
php artisan serve --host=localhost --port=8000
```

---

## 🔗 Useful Commands

```bash
# Development
php artisan serve                              # Start server
php artisan tinker                             # Interactive shell
php artisan migrate:fresh --seed               # Reset & seed database
php artisan make:model Model -m                # Create model + migration
php artisan make:controller NameController     # Create controller
php artisan make:migration create_table_name   # Create migration

# Database
php artisan migrate                            # Run migrations
php artisan migrate:rollback                   # Rollback last batch
php artisan db:seed                            # Run seeders
php artisan migrate:fresh --seed               # Reset all + seed

# Maintenance
php artisan config:clear                       # Clear config cache
php artisan cache:clear                        # Clear cache
php artisan view:clear                         # Clear view cache
php artisan optimize:clear                     # Clear all caches

# Testing
php artisan test                               # Run tests
php artisan test --filter=TestName             # Run specific test
```

---

## ✅ Checklist Awal Setup

- [ ] MySQL installed dan running
- [ ] Laragon installed (PHP, composer, etc)
- [ ] `.env` file configured dengan APP_URL=http://localhost:8000
- [ ] Database created: `bengkel`
- [ ] Migrations ran: `php artisan migrate:fresh --seed`
- [ ] Script `start-server.bat` tersedia
- [ ] Server bisa diakses di http://localhost:8000

---

**Happy coding! 🚀**
