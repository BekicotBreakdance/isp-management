# ISP Management System

> Sistem manajemen jaringan internet berbasis web untuk operator ISP lokal dan RT/RW Net. Dibangun menggunakan **PHP Native** dan **MySQL** dengan tampilan modern berbasis CSS kustom.

---

## Fitur Utama

| Modul                   | Deskripsi                                                             |
| ----------------------- | --------------------------------------------------------------------- |
| 🏠 **Dashboard**        | Statistik real-time: total pelanggan, paket, router, estimasi tagihan |
| 👤 **Pelanggan**        | CRUD data pelanggan + relasi ke paket, modem, router                  |
| 📶 **Paket Internet**   | Kelola paket layanan internet (kecepatan & harga)                     |
| 🔀 **Queue / Mikrotik** | Manajemen IP address dan username Mikrotik                            |
| 💳 **Billing**          | Tagihan bulanan pelanggan + filter status pembayaran                  |
| 🔧 **Teknisi**          | Data teknisi lapangan                                                 |
| 🛠️ **Maintenance**      | Catatan kendala lapangan + alat yang digunakan                        |
| 🪛 **Alat Maintenance** | Inventaris alat teknis                                                |
| 📦 **Modem**            | Data inventaris modem                                                 |
| 🌐 **Router**           | Data inventaris router                                                |
| 🔍 **Pencarian**        | Search pelanggan (nama/alamat), billing (nama + status)               |

---

## Tech Stack

| Layer           | Teknologi                                   |
| --------------- | ------------------------------------------- |
| Backend         | PHP Native Procedural                       |
| Database        | MySQL via XAMPP                             |
| Frontend        | HTML5, CSS3 (Custom Design System)          |
| Grid Form       | Bootstrap 5.3 (grid saja — `row` & `col-*`) |
| Font            | Google Fonts — Inter                        |
| Version Control | Git + GitHub                                |

> **Catatan**: Tampilan (~90%) dibangun menggunakan CSS kustom (`style.css`). Bootstrap hanya digunakan untuk sistem grid layout pada halaman form.

---

## Struktur Project

```
isp-management/
│
├── assets/
│   ├── css/
│   │   └── style.css          ← Design system utama (CSS Variables & komponen)
│   ├── images/
│   └── js/
│
├── backend/
│   ├── config/
│   │   ├── connect.php        ← Koneksi DB
│   │   └── auth_check.php     ← Guard autentikasi session
│   ├── auth/
│   │   ├── login.php          ← Proses login + buat user default
│   │   └── logout.php         ← Hapus session & redirect
│   ├── pelanggan/             ← tambah.php, edit.php, hapus.php
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
│   ├── alat_mt/
│   └── search.php             ← Pencarian global lintas tabel
│
├── database/
│   └── isp_management.sql     ← Schema + data awal (termasuk user admin)
│
├── docs/
│   └── tabeldatappl.xlsx      ← Dokumentasi tabel data
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

Buat file `backend/config/connect.php` (gunakan `connect.example.php` sebagai template):

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

> Semua relasi menggunakan `ON UPDATE CASCADE`. Penghapusan data induk yang masih dipakai anakan diproteksi di sisi PHP (bukan hanya database) untuk memberikan pesan error yang ramah pengguna.

---

## Keamanan

- Semua halaman backend (`tambah`, `edit`, `hapus`) dilindungi `session_start()` + `auth_check.php`
- Input teks diproteksi dengan `mysqli_real_escape_string()`
- Input numerik diproteksi dengan casting `(int)` untuk mencegah SQL Injection
- Password login di-hash menggunakan `password_hash()` + diverifikasi dengan `password_verify()`
- Login menggunakan **Prepared Statement** (`mysqli_prepare`)

---

## Tim Pengembang

**Tugas Akhir Semester 2 — Universitas Muria Kudus (UMK)**

| Nama                    | NIM       |
| ----------------------- | --------- |
| Robit Udin              | 202551060 |
| Muhammad Angling Gading | 202551143 |
| Dinda Putri Nirmala     | 202551056 |
| Zulfa Khoirun Nada      | 202551002 |

---

## Catatan

- Project ini dibuat untuk keperluan pembelajaran CRUD PHP Native semester 2.
- Tidak menggunakan framework, REST API, atau OOP kompleks.
- Fokus pada keterbacaan kode dan prinsip dasar pemrograman web.

---

**Status:** ✅ Selesai
