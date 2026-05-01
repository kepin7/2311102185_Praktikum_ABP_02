# 🏪 Inventaris Toko Pak Cokomi & Mas Wowo

> Sistem manajemen inventaris berbasis web menggunakan Laravel 13 dengan autentikasi Breeze dan sistem role berbasis kolom database (Admin, Staff, Customer).

<br>

---

## 📸 Screenshots

### Halaman Login
```
[ Screenshot Login Page ]
Simpan file gambar sebagai: docs/screenshots/login.png
Lalu ganti baris ini dengan: ![Login](docs/screenshots/login.png)
```

---

### Halaman Register
```
[ Screenshot Register Page ]
Simpan file gambar sebagai: docs/screenshots/register.png
Lalu ganti baris ini dengan: ![Register](docs/screenshots/register.png)
```

---

### Halaman Inventaris Produk — Tampilan Admin
```
[ Screenshot Halaman Index Login sebagai Admin (Pak Cokomi) ]
Simpan file gambar sebagai: docs/screenshots/index-admin.png
Lalu ganti baris ini dengan: ![Index Admin](docs/screenshots/index-admin.png)
```

---

### Halaman Inventaris Produk — Tampilan Staff
```
[ Screenshot Halaman Index Login sebagai Staff (Mas Wowo) ]
Simpan file gambar sebagai: docs/screenshots/index-staff.png
Lalu ganti baris ini dengan: ![Index Staff](docs/screenshots/index-staff.png)
```

---

### Halaman Inventaris Produk — Tampilan Customer
```
[ Screenshot Halaman Index Login sebagai Customer (view only) ]
Simpan file gambar sebagai: docs/screenshots/index-customer.png
Lalu ganti baris ini dengan: ![Index Customer](docs/screenshots/index-customer.png)
```

---

### Form Tambah Produk
```
[ Screenshot Form Tambah Produk ]
Simpan file gambar sebagai: docs/screenshots/create.png
Lalu ganti baris ini dengan: ![Create](docs/screenshots/create.png)
```

---

### Form Edit Produk
```
[ Screenshot Form Edit Produk ]
Simpan file gambar sebagai: docs/screenshots/edit.png
Lalu ganti baris ini dengan: ![Edit](docs/screenshots/edit.png)
```

---

### Modal Konfirmasi Hapus
```
[ Screenshot Modal Konfirmasi Hapus ]
Simpan file gambar sebagai: docs/screenshots/delete-modal.png
Lalu ganti baris ini dengan: ![Delete Modal](docs/screenshots/delete-modal.png)
```

---

### Fitur Search & Filter
```
[ Screenshot Fitur Search & Filter ]
Simpan file gambar sebagai: docs/screenshots/filter.png
Lalu ganti baris ini dengan: ![Filter](docs/screenshots/filter.png)
```

<br>

---

## 📦 Fitur Utama

- **Autentikasi** — Login, register, logout via Laravel Breeze
- **Sistem Role** — Admin, Staff, Customer berbasis kolom `role` di tabel users
- **Register Otomatis** — User yang mendaftar sendiri otomatis mendapat role Customer
- **CRUD Produk** — Tambah, lihat, edit, hapus produk inventaris
- **Upload Foto** — Upload & preview foto produk via Intervention Image
- **DataTable Interaktif** — Pencarian, sorting, paginasi real-time
- **Filter Produk** — Filter berdasarkan kategori, status, dan kondisi stok
- **Modal Konfirmasi Delete** — Cegah penghapusan tidak sengaja
- **Stats Dashboard** — Ringkasan total, aktif, menipis, dan habis
- **Factory & Seeder** — Data dummy otomatis saat setup

<br>

---

## 🛠️ Tech Stack

| Layer | Teknologi |
|---|---|
| Framework | Laravel 13 |
| Auth | Laravel Breeze |
| Sistem Role | Custom (kolom `role` di tabel users) |
| Upload Gambar | Intervention Image |
| CSS Framework | Tailwind CSS (CDN) |
| DataTable | jQuery DataTables (CDN) |
| Database | MySQL |
| Dummy Data | Eloquent Factory + Seeder |

<br>

---

## 👤 Hak Akses Per Role

| Fitur | Admin (Pak Cokomi) | Staff (Mas Wowo) | Customer |
|---|:---:|:---:|:---:|
| Lihat daftar produk | ✅ | ✅ | ✅ |
| Tambah produk | ✅ | ❌ | ❌ |
| Edit produk | ✅ | ✅ | ❌ |
| Hapus produk | ✅ | ❌ | ❌ |
| Upload foto produk | ✅ | ✅ | ❌ |
| Filter & search | ✅ | ✅ | ✅ |
| Register akun sendiri | ❌ | ❌ | ✅ |

<br>

---

## 🚀 Cara Instalasi

### Prasyarat
- PHP >= 8.2
- Composer
- MySQL
- XAMPP / Laragon (atau MySQL standalone)

### 1. Clone Repository
```bash
git clone https://github.com/hizkiakevin8/inventaris-cokomi.git
cd inventaris-cokomi
```

### 2. Install Dependensi PHP
```bash
composer install
```

### 3. Konfigurasi Environment
```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventaris_cokomi
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Buat Database
Buka phpMyAdmin, buat database baru:
```sql
CREATE DATABASE inventaris_cokomi;
```

### 5. Jalankan Migration + Seeder
```bash
php artisan migrate --seed
```

> Perintah ini akan membuat semua tabel, akun admin & staff, dan mengisi **20 produk dummy** otomatis.

### 6. Jalankan Server
```bash
php artisan serve
```

Buka browser: **http://localhost:8000**

<br>

---

## 👤 Akun Default

| Nama | Email | Password | Role |
|---|---|---|---|
| Pak Cokomi | cokomi@toko.com | password | Admin |
| Mas Wowo | wowo@toko.com | password | Staff |
| *(Register sendiri)* | bebas | bebas | Customer |

> **Customer** dapat mendaftar sendiri melalui halaman Register. Role customer diberikan otomatis saat registrasi.

<br>

---

## 📁 Struktur Project

```
app/
├── Http/Controllers/
│   ├── Auth/
│   │   └── RegisteredUserController.php  ← Auto assign role customer saat register
│   └── ProductController.php             ← CRUD produk + pengecekan role
├── Models/
│   ├── Product.php                       ← Model produk + accessor + scopes
│   └── User.php                          ← Model user + method hasRole() custom
database/
├── factories/
│   └── ProductFactory.php                ← Data dummy produk realistis per kategori
├── migrations/
│   ├── xxxx_create_users_table.php
│   ├── xxxx_add_role_to_users_table.php  ← Kolom role (admin/staff/customer)
│   └── xxxx_create_products_table.php
├── seeders/
│   ├── DatabaseSeeder.php
│   ├── UserSeeder.php                    ← Buat akun Pak Cokomi & Mas Wowo
│   └── ProductSeeder.php                 ← 20 produk dummy
resources/views/
├── auth/
│   ├── login.blade.php                   ← Halaman login + link ke register
│   └── register.blade.php               ← Halaman register customer
├── products/
│   ├── index.blade.php                   ← DataTable + filter + modal delete
│   ├── create.blade.php                  ← Form tambah + upload foto
│   └── edit.blade.php                    ← Form edit + preview foto lama
├── layouts/
│   └── app.blade.php                     ← Layout utama (sidebar + topbar + badge role)
routes/
└── web.php
```

<br>

---

## 🔗 Route List

| Method | URI | Controller | Akses |
|---|---|---|---|
| GET | / | redirect | Public |
| GET | /login | Breeze | Public |
| GET | /register | Breeze | Public |
| GET | /products | index() | Admin, Staff, Customer |
| GET | /products/create | create() | Admin |
| POST | /products | store() | Admin |
| GET | /products/{id}/edit | edit() | Admin, Staff |
| PUT | /products/{id} | update() | Admin, Staff |
| DELETE | /products/{id} | destroy() | Admin |

<br>

---

## 🗂️ Kategori & Satuan Produk

**Kategori:** Makanan, Minuman, Snack, Kebutuhan Rumah, Peralatan, Lainnya

**Satuan:** pcs, kg, gram, liter, ml, lusin, pak, dus

**Indikator Stok:**
- 🟢 **Tersedia** — stok > 10
- 🟡 **Menipis** — stok 1–10
- 🔴 **Habis** — stok = 0

<br>

---

## ⚙️ Perintah Berguna

```bash
# Reset database + isi ulang data dummy
php artisan migrate:fresh --seed

# Cek semua route yang terdaftar
php artisan route:list

# Cek status migration
php artisan migrate:status

# Jalankan server development
php artisan serve
```

<br>

---

## 👨‍💻 Informasi Pengembang

| | |
|---|---|
| **Nama** | [Nama Kamu] |
| **NIM** | 2311102185 |
| **Kelas** | [Kelas] |
| **Mata Kuliah** | Praktikum Aplikasi Berbasis Platform |
| **Institusi** | Telkom University Purwokerto |
| **Tahun** | 2025/2026 |

<br>

---

> Dibuat sebagai tugas praktikum mata kuliah Aplikasi Berbasis Platform  
> Telkom University Purwokerto — Semester 6