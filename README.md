# 🌐 ISP Management System

Sistem manajemen ISP / RT-RW Net berbasis **PHP Native** dan **MySQL** untuk mengelola pelanggan internet, billing, maintenance, queue Mikrotik, teknisi, modem, dan router.

---

# 🚀 Features

* Dashboard dinamis
* CRUD Pelanggan
* CRUD Paket Internet
* CRUD Queue / Mikrotik
* CRUD Modem
* CRUD Router
* CRUD Teknisi
* CRUD Maintenance
* CRUD Billing
* Statistik dashboard realtime
* Relational Database MySQL
* UI modern berbasis Bootstrap

---

# 🛠️ Tech Stack

* PHP Native (Procedural)
* MySQL
* XAMPP
* HTML / CSS / Bootstrap
* JavaScript
* GitHub

---

# 📂 Project Structure

```bash
isp-management/
│
├── assets/
│   ├── css/
│   └── js/
│
├── backend/
│   ├── config/
│   │   └── connect.php
│   ├── pelanggan/
│   ├── paket/
│   ├── queue/
│   ├── modem/
│   ├── router/
│   ├── teknisi/
│   ├── maintenance/
│   └── billing/
│
├── templates/
│   ├── dashboard/
│   ├── pelanggan/
│   ├── paket/
│   ├── queue/
│   ├── modem/
│   ├── router/
│   ├── teknisi/
│   ├── maintenance/
│   └── billing/
│
└── database/
    └── isp_management.sql
```

---

# ⚙️ Installation

## 1. Clone Repository

```bash
git clone https://github.com/BekicotBreakdance/isp-management.git
```

---

## 2. Move Project

Pindahkan folder project ke:

```bash
C:/xampp/htdocs/
```

---

## 3. Import Database

* Buka phpMyAdmin
* Buat database:

```sql
isp_management
```

* Import file:

```bash
database/isp_management.sql
```

---

## 4. Setup Database Connection

Edit file:

```bash
backend/config/connect.php
```

Sesuaikan:

```php
$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "isp_management"
);
```

---

## 5. Run Project

Aktifkan:

* Apache
* MySQL

di XAMPP.

Buka browser:

```bash
http://localhost/isp-management
```

---

# 📊 Main Modules

| Module      | Description             |
| ----------- | ----------------------- |
| Dashboard   | Statistik & monitoring  |
| Pelanggan   | Data pelanggan internet |
| Paket       | Paket internet          |
| Queue       | Queue / Mikrotik        |
| Billing     | Tagihan pelanggan       |
| Maintenance | Maintenance & kendala   |
| Teknisi     | Data teknisi            |
| Modem       | Data modem              |
| Router      | Data router             |

---

# 👨‍💻 Team

Project tugas akhir semester 2
- Robit Udin 202551060 UMK
- Muhammad Angling Gading 202551143 UMK
- Dinda Putri Nirmala 202551056 UMK
- Zulfa Khoirun Nada 202551002 UMK

---

# 📌 Notes

* Project dibuat untuk pembelajaran CRUD PHP Native.
* Menggunakan relational database MySQL.
* Fokus pada sistem management ISP sederhana.
* Tidak menggunakan framework.

---

# 🗿 Status

🚧 On Development
