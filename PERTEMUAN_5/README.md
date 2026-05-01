# Inventaris Toko Pak Cokomi & Mas Wowo

> Sistem manajemen inventaris berbasis web menggunakan Laravel 13 dengan autentikasi Breeze dan sistem role berbasis kolom database (Admin, Staff, Customer).

<br>

---

## Screenshots Output

### Halaman Login

<img width="1919" height="1028" alt="image" src="https://github.com/user-attachments/assets/e44295fa-7a1d-486d-b423-c358bc06b001" />

---

### Halaman Register

<img width="1919" height="1022" alt="image" src="https://github.com/user-attachments/assets/1ae7519f-09fd-4313-821d-1ebd89c3fda0" />

---

### Halaman Inventaris Produk — Tampilan Admin

<img width="1919" height="1025" alt="image" src="https://github.com/user-attachments/assets/54649439-b4ac-4dd8-b9c4-56c99acc8fd6" />

---

### Halaman Inventaris Produk — Tampilan Staff

<img width="1919" height="1022" alt="image" src="https://github.com/user-attachments/assets/96aa45ba-870f-4df6-a44e-8d293bccf566" />

---

### Halaman Inventaris Produk — Tampilan Customer

<img width="1919" height="1027" alt="image" src="https://github.com/user-attachments/assets/88970830-54c9-45de-b319-be5c214bb3df" />

---

### Form Tambah Produk

<img width="1919" height="1020" alt="image" src="https://github.com/user-attachments/assets/7b24b588-fa02-4e96-ac44-f270282393ff" />

---

### Form Edit Produk

<img width="1919" height="1026" alt="image" src="https://github.com/user-attachments/assets/b631ef88-92ec-4328-b32b-6ec972a406a0" />

---

### Modal Konfirmasi Hapus

<img width="1919" height="1025" alt="image" src="https://github.com/user-attachments/assets/6912657f-34bd-4e28-93dd-75c618427d99" />

---

### Fitur Search & Filter

<img width="1919" height="1022" alt="image" src="https://github.com/user-attachments/assets/3a333c0d-5d2c-41b6-bc1b-503225c40e43" />

---

<img width="1919" height="1023" alt="image" src="https://github.com/user-attachments/assets/1d61b4a5-92c5-4c2b-ae75-9757a8f47556" />


<br>

---

## Fitur Utama

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

## Tech Stack

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

## Hak Akses Per Role

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

## Cara Instalasi

### Prasyarat
- PHP >= 8.2
- Composer
- MySQL
- XAMPP / Laragon (atau MySQL standalone)

### 1. Clone Repository
```bash
git clone https://github.com/kepin7/2311102185_Praktikum_ABP_02.git
cd PERTEMUAN_5
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
DB_DATABASE=pertemuan_5
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Buat Database
Buka phpMyAdmin, buat database baru:
```sql
CREATE DATABASE pertemuan_5;
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

## Akun Default

| Nama | Email | Password | Role |
|---|---|---|---|
| Pak Cokomi | cokomi@toko.com | cokomi123 | Admin |
| Mas Wowo | wowo@toko.com | wowo123 | Staff |
| *(Register sendiri)* | bebas | bebas | Customer |

> **Customer** dapat mendaftar sendiri melalui halaman Register. Role customer diberikan otomatis saat registrasi.

<br>

---

## Struktur Project

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

## Route List

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
