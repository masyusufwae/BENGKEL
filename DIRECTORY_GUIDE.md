# 📁 Directory Structure Guide

Penjelasan lengkap setiap folder dan file di BENGKEL project.

---

## 🏗️ Root Level Files

```
BENGKEL/
├── artisan                      # Laravel CLI tool - run php artisan help
├── composer.json               # PHP dependencies & configuration
├── composer.lock               # Locked versions (auto-generated)
├── package.json                # Node.js dependencies
├── package-lock.json           # Locked npm versions
├── .env                        # Environment variables (SENSITIVE - never commit)
├── .env.example                # Example .env (safe to commit)
├── .gitignore                  # Git ignore patterns
├── phpunit.xml                 # PHPUnit testing configuration
├── vite.config.js              # Vite bundler configuration
├── tailwind.config.js           # Tailwind CSS configuration (if created)
├── README.md                   # Project README
├── start-server.bat            # Windows batch server starter
├── start-server.ps1            # PowerShell server starter
├── SERVER_SETUP.md             # Setup guide (THIS PROJECT)
├── PROJECT_GUIDE.md            # Detailed project guide
├── QUICKSTART.md               # Quick start for developers
├── FEATURES.md                 # Feature checklist
├── API_REFERENCE.md            # API endpoints documentation
├── TROUBLESHOOTING.md          # Common issues & solutions
└── DIRECTORY_GUIDE.md          # This file
```

---

## 📂 App Directory Structure

```
app/
├── Http/
│   ├── Controllers/                    # All application controllers
│   │   ├── DashboardController.php     # ✅ Role-based dashboard logic
│   │   ├── CustomerController.php      # ✅ Customer portal operations
│   │   ├── ProfileController.php       # ✅ User profile management
│   │   ├── Admin/                      # Admin controllers directory
│   │   │   ├── JenisServisController.php
│   │   │   ├── MekanikController.php
│   │   │   ├── SparepartController.php
│   │   │   └── WorkOrderController.php
│   │   └── Auth/                       # Authentication controllers (from Breeze)
│   │       ├── RegisteredUserController.php
│   │       ├── AuthenticatedSessionController.php
│   │       └── ...
│   │
│   ├── Middleware/
│   │   ├── Authenticate.php            # Check if user logged in
│   │   ├── Authorize.php               # Check user permissions
│   │   ├── VerifyCsrfToken.php        # CSRF protection
│   │   └── ...
│   │
│   └── Requests/                       # Form request validation
│       └── (auto-generated when needed)
│
├── Models/                             # Database models (Eloquent ORM)
│   ├── User.php                        # ✅ Authentication model with roles
│   ├── KendaraanPelanggan.php          # ✅ Customer vehicles
│   ├── WorkOrder.php                   # ✅ Service orders/requests
│   ├── InvoiceServis.php               # ✅ Service invoices
│   ├── Mekanik.php                     # ✅ Technician management
│   ├── JenisServis.php                 # ✅ Service types catalog
│   ├── Sparepart.php                   # ✅ Spare parts inventory
│   ├── DetailServisWo.php              # ✅ Service details per order
│   └── PenggunaanSparepart.php         # ✅ Spare part usage tracking
│
├── Providers/
│   ├── AppServiceProvider.php          # Bootstrap application services
│   ├── AuthServiceProvider.php         # Authorization & gates
│   ├── EventServiceProvider.php        # Event listeners
│   └── RouteServiceProvider.php        # Route registration
│
├── Exceptions/
│   └── Handler.php                     # Global exception handler
│
├── Jobs/                               # Queued jobs (for async tasks)
│   └── (auto-generated)
│
└── Events/                             # Application events
    └── (auto-generated)
```

---

## 📄 Bootstrap Directory

```
bootstrap/
├── app.php                     # App instance creation
├── cache/                      # Cached files (auto-generated)
│   ├── packages.php            # Composer packages cache
│   └── services.php            # Service providers cache
└── providers.php               # Discovered service providers
```

---

## ⚙️ Config Directory

```
config/
├── app.php                     # App name, timezone, locale, providers
├── auth.php                    # Authentication guards & providers
├── cache.php                   # Cache store configuration
├── database.php                # Database connections
├── filesystems.php             # Storage disk configuration
├── logging.php                 # Logging channels setup
├── mail.php                    # Email configuration
├── queue.php                   # Queue driver configuration
├── services.php                # Third-party services config
├── session.php                 # Session configuration
└── view.php                    # Blade templating paths
```

---

## 🗃️ Database Directory

```
database/
├── migrations/                 # Database schema definitions
│   ├── 0001_01_01_000000_create_users_table.php
│   │   └── Creates: users, password_reset_tokens, sessions tables
│   ├── 0001_01_01_000001_create_cache_table.php
│   │   └── Creates: cache, cache_locks tables
│   ├── 0001_01_01_000002_create_jobs_table.php
│   │   └── Creates: jobs, job_batches, failed_jobs tables
│   └── 2024_04_13_update_users_table.php
│       └── Adds: role, no_telp, alamat to users table
│
├── seeders/                    # Test data generators
│   ├── DatabaseSeeder.php      # Main seeder (calls others)
│   ├── UserSeeder.php          # Seed users with all roles
│   ├── MekanikSeeder.php       # Seed mechanic data
│   ├── KendaraanSeeder.php     # Seed customer vehicles
│   ├── JenisServisSeeder.php   # Seed service types
│   ├── WorkOrderSeeder.php     # Seed service orders
│   ├── InvoiceSeeder.php       # Seed invoices
│   ├── SparepartSeeder.php     # Seed spare parts
│   └── DetailServisSeeder.php  # Seed service details
│
└── factories/
    └── UserFactory.php         # Factory for generating test users
```

---

## 📦 Resources Directory

```
resources/
├── views/                      # Blade templates (HTML rendering)
│   ├── customer/               # ✅ Customer portal
│   │   ├── dashboard/
│   │   │   └── index.blade.php          # Main dashboard
│   │   ├── vehicles/
│   │   │   ├── index.blade.php          # List vehicles
│   │   │   └── create.blade.php         # Register vehicle form
│   │   ├── orders/
│   │   │   ├── index.blade.php          # List service orders
│   │   │   └── create.blade.php         # Create order form
│   │   └── invoices/
│   │       └── index.blade.php          # List invoices
│   │
│   ├── admin/                  # 🟡 Admin panel (TODO: views)
│   │   ├── jenis-servis/
│   │   ├── mekanik/
│   │   ├── sparepart/
│   │   └── work-orders/
│   │
│   ├── auth/                   # ✅ Authentication pages
│   │   ├── register.blade.php
│   │   ├── login.blade.php
│   │   ├── forgot-password.blade.php
│   │   ├── reset-password.blade.php
│   │   ├── verify-email.blade.php
│   │   └── confirm-password.blade.php
│   │
│   ├── layouts/                # ✅ Layout templates
│   │   ├── app.blade.php       # Main layout
│   │   └── guest.blade.php     # Guest/public layout
│   │
│   ├── components/             # ✅ Reusable components
│   │   ├── alert.blade.php
│   │   ├── form-input.blade.php
│   │   ├── button.blade.php
│   │   └── ...
│   │
│   ├── welcome.blade.php       # ✅ Homepage
│   └── dashboard.blade.php     # Dashboard redirect template
│
├── css/
│   └── app.css                 # Tailwind CSS imports
│       └── @tailwind directives
│
└── js/
    ├── app.js                  # Vue.js entry point
    ├── bootstrap.js            # Initialize Vue app
    └── Components/             # Vue components
        └── (auto-generated)
```

---

## 🛣️ Routes Directory

```
routes/
├── web.php                     # ✅ Web application routes
│   ├── Public routes (auth pages)
│   ├── Dashboard redirect
│   ├── Customer group (prefix: /customer)
│   │   ├── vehicles CRUD
│   │   ├── orders CRUD
│   │   └── invoices listing
│   ├── Profile management
│   └── (Admin routes commented/pending)
│
├── api.php                     # API routes (not used yet)
│
└── console.php                 # Artisan console commands
```

---

## 💾 Storage Directory

```
storage/
├── app/                        # Application file storage
│   ├── public/                 # Public files (symlinked)
│   └── private/                # Private files
│
├── framework/                  # Framework generated files
│   ├── cache/                  # Cache files
│   ├── sessions/               # Session files
│   ├── testing/                # Testing cache
│   └── views/                  # Compiled views cache
│
└── logs/                       # Application logs
    └── laravel.log             # Main log file
```

---

## 📋 Tests Directory

```
tests/
├── Feature/                    # Feature/integration tests
│   └── ExampleTest.php        # Example test
│
├── Unit/                       # Unit tests
│   └── ExampleTest.php        # Example test
│
└── TestCase.php               # Base test class
```

---

## 🌐 Public Directory

```
public/
├── index.php                  # Application entry point
├── robots.txt                 # Search engine instructions
├── .htaccess                  # Apache rewrite rules
├── css/                       # Compiled CSS (generated by Vite)
│   └── app.*.css
├── js/                        # Compiled JavaScript (generated by Vite)
│   └── app.*.js
└── images/                    # Public images (create as needed)
```

---

## 📦 Vendor Directory

```
vendor/                        # Third-party packages (auto-installed)
├── laravel/                   # Laravel framework packages
│   ├── framework/             # Core framework
│   ├── breeze/                # Authentication scaffolding
│   ├── tinker/                # Interactive shell
│   └── ...
├── symfony/                   # Symfony components
├── doctrine/                  # Doctrine ORM
├── phpunit/                   # Testing framework
├── composer/                  # Composer autoloader
└── ... (many more)
```

⚠️ **IMPORTANT:** Never commit vendor/ to git (use .gitignore)

---

## 🔧 Node Modules Directory

```
node_modules/                  # JavaScript packages (auto-installed)
├── tailwindcss/              # Utility CSS framework
├── vite/                      # Build tool
├── vue/                       # JavaScript framework
│   ├── @version 3.x
└── ... (many more)
```

⚠️ **IMPORTANT:** Never commit node_modules/ to git (use .gitignore)

---

## 🔐 Sensitive Files (Never Commit)

```
.env                           # Environment variables (passwords, keys)
.DS_Store                      # macOS folder metadata
Thumbs.db                      # Windows thumbnail cache
*.log                          # Log files
storage/logs/                  # Application logs
node_modules/                  # JS packages
vendor/                        # PHP packages
.vscode/settings.json          # IDE settings
```

These are already in `.gitignore`

---

## 📊 File Hierarchy Summary

```
BENGKEL (Root)
│
├── 📂 app/                    # Application code (models, controllers, etc)
├── 📂 bootstrap/              # Framework bootstrap
├── 📂 config/                 # Configuration files
├── 📂 database/               # Migrations, seeders, factories
├── 📂 resources/              # Views, CSS, JS
│   ├── views/                 # HTML templates
│   ├── css/                   # Stylesheets
│   └── js/                    # JavaScript
├── 📂 routes/                 # Route definitions
├── 📂 storage/                # Cache, sessions, logs
├── 📂 tests/                  # Unit & feature tests
├── 📂 public/                 # Web root (CSS, JS, images)
│
├── 📄 .env                    # Environment config (SENSITIVE)
├── 📄 composer.json           # PHP dependencies
├── 📄 package.json            # Node dependencies
├── 📄 artisan                 # CLI tool
├── 📄 vite.config.js          # Build configuration
├── 📄 phpunit.xml             # Test configuration
│
├── 📄 start-server.bat        # Server startup script
├── 📄 start-server.ps1        # PowerShell server script
│
├── 📄 SERVER_SETUP.md         # Server setup guide
├── 📄 PROJECT_GUIDE.md        # Detailed guide
├── 📄 QUICKSTART.md           # Quick start
├── 📄 FEATURES.md             # Feature checklist
├── 📄 API_REFERENCE.md        # API documentation
├── 📄 TROUBLESHOOTING.md      # Common issues
└── 📄 DIRECTORY_GUIDE.md      # This file
```

---

## 🎯 Common File Locations Quick Reference

| Need | Location |
|------|----------|
| Change database config | `config/database.php` |
| Add new route | `routes/web.php` |
| Create controller | `app/Http/Controllers/` |
| Create model | `app/Models/` |
| Create blade template | `resources/views/` |
| Create migration | `database/migrations/` |
| Create seeder | `database/seeders/` |
| CSS styling | `resources/css/app.css` |
| JavaScript | `resources/js/app.js` |
| Environment variables | `.env` |
| Application config | `config/app.php` |
| Cache settings | `config/cache.php` |
| Session settings | `config/session.php` |
| View all config | `config/` |

---

## 🚀 Creating New Features

### **New Controller**

```bash
php artisan make:controller FeatureController -r
# Creates: app/Http/Controllers/FeatureController.php
# -r flag = resource controller (CRUD methods)
```

Location: `app/Http/Controllers/FeatureController.php`

### **New Model**

```bash
php artisan make:model Feature -m
# Creates: 
#   app/Models/Feature.php (model)
#   database/migrations/2024_12_xx_xxxxxx_create_features_table.php
# -m flag = with migration
```

### **New Migration**

```bash
php artisan make:migration create_features_table
# Creates: database/migrations/2024_12_xx_xxxxxx_create_features_table.php
```

Run migration:
```bash
php artisan migrate
```

### **New Blade View**

Create file: `resources/views/feature/index.blade.php`

Use in controller:
```php
return view('feature.index');
```

### **New Seeder**

```bash
php artisan make:seeder FeatureSeeder
# Creates: database/seeders/FeatureSeeder.php
```

Run seeder:
```bash
php artisan db:seed --class=FeatureSeeder
```

---

## 📝 Naming Conventions

| Type | Convention | Example |
|------|-----------|---------|
| Model | Singular, PascalCase | `KendaraanPelanggan` |
| Controller | PascalCase + Controller | `CustomerController` |
| Migration | snake_case | `create_users_table.php` |
| Seeder | PascalCase + Seeder | `UserSeeder.php` |
| Route | kebab-case | `/customer/vehicles` |
| View folder | snake_case | `resources/views/customer/` |
| Database table | snake_case, plural | `users`, `work_orders` |
| Database column | snake_case | `nomor_polisi`, `id_pelanggan` |
| CSS class | kebab-case | `.btn-primary`, `.form-input` |
| Vue component | PascalCase | `CustomerForm.vue` |

---

## 💡 Pro Tips

1. **Always run migrations** after pulling from git:
   ```bash
   php artisan migrate
   ```

2. **Clear cache** if things act weird:
   ```bash
   php artisan optimize:clear
   ```

3. **Use tinker** to test model queries:
   ```bash
   php artisan tinker
   >>> User::all()
   ```

4. **Watch logs** while developing:
   ```bash
   tail -f storage/logs/laravel.log
   ```

5. **Keep .env out of git:**
   ```bash
   # Already in .gitignore, but verify:
   cat .gitignore | grep ".env"
   ```

---

**Last Updated:** 2024-12
**Framework:** Laravel 11
**Version:** 1.0
