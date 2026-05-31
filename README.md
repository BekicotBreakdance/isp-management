# ISP Management System

> Sistem manajemen jaringan internet berbasis web untuk operator ISP lokal dan RT/RW Net. Dibangun menggunakan **PHP Native** dan **MySQL** dengan tampilan modern berbasis Bootstrap.

---

## Fitur Utama

| Modul | Deskripsi |
|---|---|
| 🏠 **Dashboard** | Statistik real-time: total pelanggan, paket, router, estimasi tagihan |
| 👤 **Pelanggan** | CRUD data pelanggan + relasi ke paket, modem, router |
| 📶 **Paket Internet** | Kelola paket layanan internet (kecepatan & harga) |
| 🔀 **Queue / Mikrotik** | Manajemen IP address dan username Mikrotik |
| 💳 **Billing** | Tagihan bulanan pelanggan + filter status pembayaran |
| 🔧 **Teknisi** | Data teknisi lapangan |
| 🛠️ **Maintenance** | Catatan kendala lapangan + alat yang digunakan |
| 🪛 **Alat Maintenance** | Inventaris alat teknis |
| 📦 **Modem** | Data inventaris modem |
| 🌐 **Router** | Data inventaris router |
| 🔔 **Notifikasi** | Badge tagihan belum lunas real-time di navbar |
| 🔍 **Pencarian** | Search pelanggan (nama/alamat), billing (nama + status) |

---

## Tech Stack

| Layer | Teknologi |
|---|---|
| Backend | PHP Native Procedural |
| Database | MySQL via XAMPP |
| Frontend | HTML5, CSS3 (Custom), Bootstrap 5.3 |
| Font | Google Fonts — Inter |
| Version Control | Git + GitHub |

---

## Struktur Project

```
isp-management/
│
├── assets/
│   └── css/
│       └── style.css          ← Theme utama (CSS Variables)
│
├── backend/
│   ├── config/
│   │   └── connect.php        ← Koneksi DB (di-gitignore)
│   ├── auth/
│   ├── pelanggan/
│   ├── paket/
│   ├── queue/
│   ├── modem/
│   ├── router/
│   ├── teknisi/
│   ├── maintenance/
│   ├── billing/
│   ├── alat_mt/
│   └── detail_alat_mt/
│
├── templates/
│   ├── layouts/
│   │   ├── header.php         ← Session check + asset loading
│   │   ├── sidebar.php        ← Navigasi utama
│   │   └── navbar.php         ← Topbar + notifikasi dinamis
│   ├── auth/
│   │   └── login.php
│   ├── dashboard/
│   ├── pelanggan/
│   ├── paket/
│   ├── queue/
│   ├── modem/
│   ├── router/
│   ├── teknisi/
│   ├── maintenance/
│   ├── billing/
│   └── alat_mt/
│
├── database/
│   └── isp_management.sql     ← Schema + data awal
│
├── .gitignore
└── index.php                  ← Entry point → redirect ke login
```

---

## Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/BekicotBreakdance/isp-management.git
```

### 2. Pindahkan ke XAMPP

```
C:/xampp/htdocs/isp-management/
```

### 3. Buat Koneksi Database

Buat file `backend/config/connect.php`:

```php
<?php
$host   = 'localhost';
$user   = 'root';
$pass   = '';          // sesuaikan
$db     = 'isp_management';
$conn   = mysqli_connect($host, $user, $pass, $db);
if (!$conn) die("Koneksi gagal: " . mysqli_connect_error());
```

### 4. Import Database

- Buka **phpMyAdmin** → `http://localhost/phpmyadmin`
- Buat database: `isp_management`
- Import: `database/isp_management.sql`

### 5. Jalankan

Aktifkan **Apache** dan **MySQL** di XAMPP, lalu buka:

```
http://localhost/isp-management
```

---

## Login Default

```
Username : admin
Password : admin123
```

> Password di-hash menggunakan `password_hash()` PHP. Dapat diubah langsung di tabel `users` via phpMyAdmin.

---

## Relasi Database

```
pelanggan ──┬── paket
            ├── modem
            └── router

billing ────── pelanggan

queue ─────── pelanggan

maintenance ─┬── pelanggan
             ├── teknisi
             └── detail_alat_mt ── alat_mt
```

---

## Tim Pengembang

**Tugas Akhir Semester 2 — Universitas Muria Kudus (UMK)**

| Nama | NIM |
|---|---|
| Robit Udin | 202551060 |
| Muhammad Angling Gading | 202551143 |
| Dinda Putri Nirmala | 202551056 |
| Zulfa Khoirun Nada | 202551002 |

---

## Catatan

- Project ini dibuat untuk keperluan pembelajaran CRUD PHP Native semester 2.
- Tidak menggunakan framework, REST API, atau OOP kompleks.
- Fokus pada keterbacaan kode dan prinsip dasar pemrograman web.

---

**Status:** ✅ Selesai — Siap Presentasi
