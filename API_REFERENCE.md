# 🔌 API Reference - BENGKEL

Dokumentasi lengkap API endpoints dan cara menggunakannya.

---

## 🔑 Authentication

Semua endpoint memerlukan authenticated user (login terlebih dahulu).

### **Session-Based Auth (Default)**
- Menggunakan cookies & session
- Automatic CSRF protection
- Login via `/login` route

### **API Token Auth (Optional)**
Belum implemented, tapi bisa ditambah jika diperlukan:
```php
// .env
SANCTUM_STATEFUL_DOMAINS=localhost:8000
```

---

## 👥 Customer Routes

### **1. Vehicles (Kendaraan)**

#### **List Vehicles**
```http
GET /customer/vehicles
```

**Response:**
```blade
Views all customer vehicles with:
- nomor_polisi, merek, model, tahun, warna, bahan_bakar
- Service history per vehicle
- Status badge
```

#### **Create Vehicle (Form)**
```http
GET /customer/vehicles/create
```

**Response:** Form page

#### **Store Vehicle**
```http
POST /customer/vehicles
Content-Type: application/x-www-form-urlencoded

Parameters:
  nomor_polisi        [required] string    - License plate
  merek               [required] string    - Vehicle brand
  model               [required] string    - Vehicle model
  tahun               [required] integer   - Year
  warna               [required] string    - Color
  jenis_bahan_bakar   [required] string    - Fuel type (Bensin/Diesel/Listrik)
```

**Response:**
```
Status: 302 Redirect
Location: /customer/vehicles
Msg: Vehicle registered successfully
```

---

### **2. Work Orders (Service Requests)**

#### **List Orders**
```http
GET /customer/orders
```

**Query Parameters:**
```
status=all|aktif|selesai  (optional, defaults to 'all')
```

**Response:**
```blade
Displays:
- Order list with status badge
- Vehicle used
- Keluhan (complaint description)
- Tanggal masuk, estimasi selesai
- Action buttons (view detail, cancel, etc)
```

#### **Create Order (Form)**
```http
GET /customer/orders/create
```

**Response:** Form with:
- Vehicle selector (dropdown from user's vehicles)
- Keluhan textarea
- Submit button

#### **Store Order**
```http
POST /customer/orders
Content-Type: application/x-www-form-urlencoded

Parameters:
  id_kendaraan        [required] integer   - Vehicle ID
  keluhan             [required] string    - Complaint/Issue description
```

**Response:**
```
Status: 302 Redirect
Location: /customer/orders
Message: Order created successfully
```

**Behind the scenes:**
```php
// Auto-generated:
- nomor_wo (work order number)
- status = "Pending"
- tanggal_masuk = now()
- created_by = auth()->user()->id
```

---

### **3. Invoices**

#### **List Invoices**
```http
GET /customer/invoices
```

**Response:**
```blade
Shows:
- Invoice list with payment status
- Total biaya per invoice
- Tanggal invoice
- Action buttons (view detail, download, pay)

Summary cards:
- Total invoices
- Total bayar, Sudah dibayar, Belum dibayar
```

---

## 🔐 Auth Routes

### **Register**

#### **Show Register Form**
```http
GET /register
```

#### **Submit Registration**
```http
POST /register
Content-Type: application/x-www-form-urlencoded

Parameters:
  name                [required] string  - Full name
  email               [required] email   - Email address
  password            [required] string  - Min 8 chars
  password_confirmation [required] string - Must match password
  role                [optional] string  - pelanggan|mekanik|admin (default: pelanggan)
  no_telp             [optional] string  - Phone number
  alamat              [optional] string  - Address
```

**Response:**
```
Status: 302
Location: /dashboard
Message: Registration successful, email verification sent
```

---

### **Login**

#### **Show Login Form**
```http
GET /login
```

#### **Submit Login**
```http
POST /login
Content-Type: application/x-www-form-urlencoded

Parameters:
  email               [required] string   - Email address
  password            [required] string   - Password
  remember            [optional] checkbox - Remember me
```

**Response:**
```
Status: 302
Location: /dashboard
Cookie: laravel_session=...
```

---

### **Logout**

```http
POST /logout
```

**Response:**
```
Status: 302
Location: /login
Message: Logged out successfully
```

---

### **Password Reset**

#### **Request Reset Form**
```http
GET /forgot-password
```

#### **Send Reset Email**
```http
POST /forgot-password
Content-Type: application/x-www-form-urlencoded

Parameters:
  email               [required] string   - Email address
```

**Response:**
```
Status: 302
Message: Reset link sent to email
```

#### **Show Reset Form**
```http
GET /reset-password/{token}

Parameters:
  token (path)        [required] string   - Reset token from email
  email (query)       [required] string   - Email address
```

#### **Submit New Password**
```http
POST /reset-password
Content-Type: application/x-www-form-urlencoded

Parameters:
  token               [required] string   - Reset token
  email               [required] string   - Email address
  password            [required] string   - New password
  password_confirmation [required] string - Confirmation
```

---

### **Profile Management**

#### **View Profile**
```http
GET /profile
```

#### **Update Profile**
```http
PATCH /profile
Content-Type: application/x-www-form-urlencoded

Parameters:
  name                [optional] string   - Update name
  email               [optional] string   - Update email
  no_telp             [optional] string   - Update phone
  alamat              [optional] string   - Update address
```

#### **Delete Account**
```http
DELETE /profile
```

**Response:**
```
Status: 302
Location: /login
Message: Account deleted successfully
```

---

## 📊 Dashboard Route

```http
GET /dashboard
```

**Response:**
Role-based redirect:
- Pelanggan → `/customer/dashboard` (customer dashboard)
- Mekanik → Mechanic dashboard (TODO)
- Admin → Admin dashboard (TODO)

---

## 🎯 Admin Routes (Ready but not integrated)

Controllers sudah dibuat tapi routes belum semua terintegrasi di `routes/web.php`.

### **Jenis Servis (Service Types)**

```http
GET    /admin/jenis-servis             (List)
POST   /admin/jenis-servis             (Create)
GET    /admin/jenis-servis/{id}/edit   (Edit form)
PUT    /admin/jenis-servis/{id}        (Update)
DELETE /admin/jenis-servis/{id}        (Delete)
```

### **Spare Parts**

```http
GET    /admin/sparepart                (List)
POST   /admin/sparepart                (Create)
GET    /admin/sparepart/{id}/edit      (Edit)
PUT    /admin/sparepart/{id}           (Update)
DELETE /admin/sparepart/{id}           (Delete)
```

### **Mechanics**

```http
GET    /admin/mekanik                  (List)
POST   /admin/mekanik                  (Create)
GET    /admin/mekanik/{id}/edit        (Edit)
PUT    /admin/mekanik/{id}             (Update)
DELETE /admin/mekanik/{id}             (Delete)
```

### **Work Orders**

```http
GET    /admin/work-orders              (List)
GET    /admin/work-orders/{id}/edit    (Edit)
PUT    /admin/work-orders/{id}         (Update status, etc)
```

---

## 🗄️ Database Query Examples

### **Get Customer's Vehicles**
```php
// In CustomerController
$vehicles = auth()->user()->kendaraan()
    ->with('workOrders')
    ->orderBy('created_at', 'desc')
    ->get();
```

### **Get Active Work Orders**
```php
$activeOrders = WorkOrder::where('status', 'Aktif')
    ->where('id_pelanggan', auth()->id())
    ->with('kendaraan', 'mekanik', 'invoice')
    ->orderBy('tanggal_masuk', 'desc')
    ->get();
```

### **Calculate Invoice Totals**
```php
$totalInvoiced = InvoiceServis::where('id_pelanggan', auth()->id())
    ->sum('total_bayar');

$totalPaid = InvoiceServis::where('id_pelanggan', auth()->id())
    ->where('status_bayar', 'Lunas')
    ->sum('total_bayar');

$totalUnpaid = $totalInvoiced - $totalPaid;
```

---

## 🔄 Request/Response Examples

### **Example: Create Vehicle**

**Request:**
```http
POST /customer/vehicles HTTP/1.1
Host: localhost:8000
Content-Type: application/x-www-form-urlencoded
Cookie: laravel_session=abc123...

nomor_polisi=B+1234+CD&merek=Toyota&model=Avanza&tahun=2020&warna=Putih&jenis_bahan_bakar=Bensin
```

**Response:**
```http
HTTP/1.1 302 Found
Location: /customer/vehicles
Set-Cookie: laravel_session=xyz789...
```

---

### **Example: Create Order**

**Request:**
```http
POST /customer/orders HTTP/1.1
Host: localhost:8000
Content-Type: application/x-www-form-urlencoded

id_kendaraan=1&keluhan=Mobil+tidak+mau+hidup
```

**Response:**
```http
HTTP/1.1 302 Found
Location: /customer/orders
X-Message: Order created successfully
```

View result:
- New WorkOrder created in database
- nomor_wo auto-generated (e.g., "WO-2024-0001")
- status = "Pending"
- notification sent to mechanic (optional future feature)

---

## 🔒 Authorization Rules

### **Customer Can:**
- ✅ View own vehicles
- ✅ Create own orders
- ✅ View own invoices
- ❌ View other customers' data
- ❌ Access admin panel

### **Mechanic Can:**
- ✅ View assigned work orders
- ✅ Update work order status
- ✅ View service details
- ❌ Create invoices
- ❌ View unauthenticated data

### **Admin Can:**
- ✅ View all data
- ✅ Manage all entities
- ✅ Generate reports
- ✅ Manage users & roles

---

## 🚨 Error Responses

### **Authentication Required**
```http
HTTP/1.1 302 Found
Location: /login
```

### **Unauthorized**
```http
HTTP/1.1 403 Forbidden
Body: "Unauthorized action"
```

### **Not Found**
```http
HTTP/1.1 404 Not Found
Body: "Resource not found"
```

### **Validation Error**
```http
HTTP/1.1 302 Found
Location: /customer/vehicles/create
Session.errors:
  - nomor_polisi is required
  - merek must be a string
```

---

## 📝 CSRF Protection

All POST, PUT, DELETE requests need CSRF token:

```blade
<form method="POST" action="/customer/vehicles">
    @csrf
    <!-- form fields -->
</form>
```

Or in AJAX:
```javascript
// Get token from meta tag
const token = document.querySelector('meta[name="csrf-token"]').content;

fetch('/customer/vehicles', {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': token,
        'Content-Type': 'application/json'
    },
    body: JSON.stringify(data)
});
```

---

## 🔗 URL Structure Reference

```
Public:
  /                          Homepage
  /login                     Login page
  /register                  Register page
  /forgot-password           Password reset form

Protected (Authenticated):
  /dashboard                 Role-based dashboard
  /profile                   User profile
  /customer/*                Customer portal routes

Admin (TODO):
  /admin/*                   Admin panel routes

API (TODO):
  /api/*                     JSON API endpoints
```

---

**Last Updated:** 2024-12
**API Version:** v1.0
