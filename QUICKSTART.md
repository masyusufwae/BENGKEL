# ⚡ Quick Start - BENGKEL

Panduan singkat untuk memulai development.

## 🚀 Start Server (30 detik)

### **Option 1: Run Batch Script (Easiest)**
```bash
./start-server.bat
# Atau double-click file tersebut
```

### **Option 2: Manual**
```bash
cd C:\laragon\www\BENGKEL
net start MySQL80              # Pastikan MySQL running (hanya sekali)
php artisan serve
```

Server will run at: **http://localhost:8000**

---

## 🔐 Login Test Accounts

| Role | Email | Password |
|------|-------|----------|
| Pelanggan | `pelanggan@bengkel.com` | `password123` |
| Mekanik | `mekanik@bengkel.com` | `password123` |
| Admin | `admin@bengkel.com` | `password123` |

---

## 📋 One-Time Setup (First Time Only)

```bash
cd C:\laragon\www\BENGKEL

# 1. Install dependencies
composer install
npm install

# 2. Setup env file
copy .env.example .env
php artisan key:generate

# 3. Start MySQL
net start MySQL80

# 4. Run migrations with dummy data
php artisan migrate:fresh --seed

# 5. Build frontend assets
npm run build
```

---

## 🛠️ Common Commands

```bash
# Development
php artisan serve                    # Start server
php artisan serve --port=8001        # Different port
npm run dev                          # Watch frontend files

# Database
php artisan migrate:fresh --seed     # Reset & repopulate
php artisan tinker                   # Interactive DB shell

# Maintenance
php artisan cache:clear
php artisan config:clear
```

---

## 🔗 Quick Links

- Dashboard: http://localhost:8000/dashboard
- Login: http://localhost:8000/login
- Customer Portal: http://localhost:8000/customer
- Documentation: See `SERVER_SETUP.md` & `PROJECT_GUIDE.md`

---

## 🐛 If Something's Wrong

**MySQL not running:**
```powershell
net start MySQL80
```

**Migrations failed:**
```bash
php artisan migrate:fresh --seed
```

**Server port already in use:**
```bash
php artisan serve --port=8001
```

---

**That's it! Happy coding 🎉**
