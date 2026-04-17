# 📱 BENGKEL - Sistem Manajemen Bengkel Kendaraan

Aplikasi Laravel 11 untuk manajemen bengkel dengan fitur customer portal, work order tracking, dan service management.

---

## 🎯 Overview

**Bengkel** adalah platform terintegrasi untuk:
- 👥 **Pelanggan** - View vehicle status, track service orders, manage invoices
- 🔧 **Mekanik** - Assign work orders, track progress, manage spare parts
- 👨‍💼 **Admin** - Manage mechanics, service types, spare parts, invoices

## 🏗️ Tech Stack

| Layer | Technology |
|-------|-----------|
| **Framework** | Laravel 11 |
| **Database** | MySQL 8.0.30 |
| **Frontend** | Vue.js 3 + Tailwind CSS 3 |
| **Build Tool** | Vite |
| **Auth** | Laravel Breeze |
| **ORM** | Eloquent |
| **Language** | PHP 8.2.12 |

---

## 📂 Project Structure

```
BENGKEL/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── DashboardController.php      # Role-based dashboard
│   │       ├── CustomerController.php       # Customer operations
│   │       ├── Admin/                       # Admin controllers
│   │       └── ...
│   ├── Models/                              # 9 Eloquent models
│   │   ├── User.php
│   │   ├── KendaraanPelanggan.php
│   │   ├── WorkOrder.php
│   │   ├── InvoiceServis.php
│   │   ├── Mekanik.php
│   │   ├── JenisServis.php
│   │   ├── Sparepart.php
│   │   ├── DetailServisWo.php
│   │   └── PenggunaanSparepart.php
│   └── Providers/
│
├── bootstrap/                               # Laravel bootstrap
│
├── config/                                  # Configuration files
│
├── database/
│   ├── migrations/                          # 12 migrations
│   ├── factories/                           # Test data factories
│   └── seeders/                             # 9 data seeders
│
├── resources/
│   ├── views/
│   │   ├── customer/                        # Customer portal
│   │   │   ├── dashboard/
│   │   │   ├── vehicles/
│   │   │   ├── orders/
│   │   │   └── invoices/
│   │   ├── admin/                           # Admin panel
│   │   ├── auth/                            # Auth pages
│   │   ├── layouts/                         # Layout templates
│   │   └── ...
│   ├── css/
│   │   └── app.css                          # Tailwind CSS
│   └── js/
│       └── app.js                           # Vue.js entry
│
├── routes/
│   ├── web.php                              # Web routes
│   ├── api.php                              # API routes (optional)
│   └── console.php                          # Console commands
│
├── storage/                                 # Session, logs, uploads
│
├── tests/                                   # Unit & Feature tests
│
├── public/
│   └── index.php                            # Entry point
│
├── .env                                     # Environment config
├── artisan                                  # Artisan CLI
├── composer.json                            # PHP dependencies
├── package.json                             # Node dependencies
├── vite.config.js                           # Vite configuration
├── phpunit.xml                              # Test configuration
│
├── start-server.bat                         # Windows batch script
├── start-server.ps1                         # PowerShell script
└── SERVER_SETUP.md                          # Server setup guide
```

---

## 🗄️ Database Schema

### **Models & Relationships**

```
Users (Authentication)
  ├─→ KendaraanPelanggan (hasMany)
  ├─→ Mekanik (hasOne)
  
KendaraanPelanggan
  ├─→ User (belongsTo) [Pelanggan]
  └─→ WorkOrder (hasMany)

WorkOrder
  ├─→ KendaraanPelanggan (belongsTo)
  ├─→ Mekanik (belongsTo)
  ├─→ DetailServisWo (hasMany)
  ├─→ PenggunaanSparepart (hasMany)
  └─→ InvoiceServis (hasMany)

InvoiceServis
  └─→ WorkOrder (belongsTo)

Mekanik
  ├─→ User (belongsTo)
  └─→ WorkOrder (hasMany)

JenisServis
  └─→ DetailServisWo (hasMany)

Sparepart
  └─→ PenggunaanSparepart (hasMany)

DetailServisWo
  └─→ JenisServis (belongsTo)

PenggunaanSparepart
  └─→ Sparepart (belongsTo)
```

### **Key Tables**

| Table | Purpose | Status |
|-------|---------|--------|
| `users` | Authentication & authorization | ✅ |
| `kendaraan_pelanggan` | Customer vehicle registry | ✅ |
| `work_orders` | Service requests | ✅ |
| `invoice_servis` | Service billing | ✅ |
| `mekanik` | Technician management | ✅ |
| `jenis_servis` | Service types catalog | ✅ |
| `sparepart` | Spare parts inventory | ✅ |
| `detail_servis_wo` | Service details per order | ✅ |
| `penggunaan_sparepart` | Spare part usage tracking | ✅ |

---

## 👥 User Roles

### **1. Pelanggan (Customer)**

**Akses:**
- Dashboard dengan vehicle status & service history
- Daftar kendaraan
- Buat service order
- Lihat invoices & payment status

**Akun Test:**
- Email: `pelanggan@bengkel.com`
- Password: `password123`

**Routes:**
- `/customer/dashboard` - Dashboard pelanggan
- `/customer/vehicles` - Manage kendaraan
- `/customer/orders` - Track service orders
- `/customer/invoices` - View invoices

### **2. Mekanik (Technician)**

**Akses:**
- Dashboard dengan work orders
- Manage assigned tasks
- Track spare parts usage
- Update work order status

**Akun Test:**
- Email: `mekanik@bengkel.com`
- Password: `password123`

### **3. Admin**

**Akses:**
- Full system management
- Add/edit mechanics
- Manage service types & spare parts
- View all invoices & reports
- User management

**Akun Test:**
- Email: `admin@bengkel.com`
- Password: `password123`

---

## 🚀 Quick Start

### **1. Ensure MySQL is Running**

```powershell
net start MySQL80
```

### **2. Setup Database**

```bash
cd C:\laragon\www\BENGKEL

# Run migrations with seeders
php artisan migrate:fresh --seed
```

### **3. Start Server**

**Option A - Batch Script (Recommended):**
```bash
start-server.bat
```

**Option B - Manual:**
```bash
php artisan serve
```

### **4. Access Application**

```
http://localhost:8000
```

Login with any test account above.

---

## 📊 Key Features

### **Dashboard Pelanggan**
- Status kendaraan (aktif/selesai)
- Riwayat layanan terbaru
- Jadwal servis mendatang
- Action buttons untuk order baru

### **Vehicle Management**
- Daftar kendaraan yang terdaftar
- Detail spesifikasi (merk, model, tahun, warna, bahan bakar)
- Riwayat servis per kendaraan

### **Service Orders**
- Buat order baru dengan keluhan
- Track status (In Progress, Completed, Pending)
- Estimate completion date
- Service history dengan detail

### **Invoicing**
- Generate invoices otomatis
- Track payment status
- Detail biaya jasa + spare parts
- Payment history

---

## 🔧 API Endpoints

### **Customer Routes (Prefix: `/customer`)**

```
GET    /customer/vehicles              → customer.vehicles.index
GET    /customer/vehicles/create       → customer.vehicles.create
POST   /customer/vehicles              → customer.vehicles.store
GET    /customer/orders                → customer.orders.index
GET    /customer/orders/create         → customer.orders.create
POST   /customer/orders                → customer.orders.store
GET    /customer/invoices              → customer.invoices.index
```

### **Admin Routes (Optional - Not fully integrated)**

```
GET    /admin/jenis-servis             → jenis-servis.index
POST   /admin/jenis-servis             → jenis-servis.store
GET    /admin/mekanik                  → mekanik.index
...
```

### **Auth Routes**

```
GET    /register                       → register
POST   /register                       → register.store
GET    /login                          → login
POST   /login                          → login.store
POST   /logout                         → logout
GET    /forgot-password                → password.request
POST   /forgot-password                → password.email
GET    /reset-password/{token}         → password.reset
POST   /reset-password                 → password.store
GET    /verify-email                   → verification.notice
POST   /verify-email/send              → verification.send
GET    /verify-email/{id}/{hash}       → verification.verify
```

---

## 🧪 Testing

### **Run All Tests**
```bash
php artisan test
```

### **Run Specific Test**
```bash
php artisan test tests/Feature/ExampleTest.php
```

### **Run with Coverage**
```bash
php artisan test --coverage
```

---

## 📦 Installation (Fresh Setup)

### **1. Install Dependencies**

```bash
composer install
npm install
```

### **2. Setup Environment**

```bash
cp .env.example .env
php artisan key:generate
```

### **3. Configure Database**

Edit `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bengkel
DB_USERNAME=root
DB_PASSWORD=
```

### **4. Run Migrations**

```bash
php artisan migrate:fresh --seed
```

### **5. Build Assets**

```bash
npm run build
# atau
npm run dev  # untuk development dengan watch
```

### **6. Start Server**

```bash
php artisan serve
```

---

## 🛠️ Development Commands

```bash
# Artisan Commands
php artisan make:migration create_table_name
php artisan make:model Model -mc
php artisan make:controller NameController -r
php artisan migrate
php artisan db:seed
php artisan tinker

# Frontend
npm run dev          # Start dev server dengan hot reload
npm run build        # Build untuk production

# Cache Management
php artisan config:cache
php artisan cache:clear
php artisan view:clear

# Database
php artisan migrate:rollback
php artisan migrate:fresh
php artisan migrate:fresh --seed
```

---

## 📝 .env Configuration

Key variables untuk development:

```env
APP_NAME=BENGKEL
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bengkel
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=log
CACHE_STORE=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

---

## 🚨 Troubleshooting

### **"Class not found" Error**

```bash
composer dump-autoload
```

### **Migration Error**

```bash
php artisan migrate:rollback
php artisan migrate:fresh --seed
```

### **CSS/JS Not Loading**

```bash
npm run build
php artisan optimize:clear
```

### **Database Connection Error**

```powershell
# Check MySQL running
net start MySQL80

# Test connection
mysql -u root -h 127.0.0.1
```

---

## 📚 Useful Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Tailwind CSS](https://tailwindcss.com/docs)
- [Vue.js 3](https://vuejs.org/)
- [Eloquent ORM](https://laravel.com/docs/eloquent)

---

## 📄 License

Private project for BENGKEL workshop management system.

---

**Last Updated:** 2024-12
**Created:** 2024-04
