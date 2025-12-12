Siap! Ini aku *rapikan versi final README* agar benar-benar *siap tempel ke GitHub*, format markdown rapi, heading konsisten, dan terlihat profesional.

---

# 🛒 Cheap N Use — Fullstack E-Commerce Laravel 12

### Ujian Praktikum Pemrograman Web (UAP) — 2025

Proyek ini merupakan implementasi aplikasi *E-Commerce Laravel 12* sesuai ketentuan UAP Pemrograman Web, mencakup:

* Role Based Access Control (RBAC)
* CRUD lengkap untuk semua role
* Sistem pembayaran *Wallet & Virtual Account (VA)*
* Dedicated Payment Page
* Dashboard Customer, Seller, dan Admin
* Brand produk utama: *Cheap N Use*

---

## 👥 Anggota Kelompok

| Nama                     | NIM                 | Jobdesk                                                                                                           |
| ------------------------ | ------------------- | ----------------------------------------------------------------------------------------------------------------- |
| *Nashifa Zulfa Insani* | *245150600111015* | *Halaman Pengguna (Customer Side)* — Homepage, Product Detail, Checkout, History, Wallet Topup                  |
| *Yusriyatul Husna*     | *245150607111012* | *Seller Dashboard + Admin Panel* — CRUD Kategori, Produk, Store Verification, Orders, Withdraw, User Management |

---

# ✅ Checklist Kesesuaian Instruksi UAP

## ✔ Setup & Requirement

* [x] Laravel 12
* [x] Laravel Breeze Authentication
* [x] Migration berjalan
* [x] .env dikonfigurasi
* [x] Seeder dibuat sesuai syarat
* [x] Vite berjalan (npm run dev)

## ✔ Database & Seeder

* [x] 1 Admin
* [x] 2 Member
* [x] 1 Store (dimiliki salah satu member)
* [x] 5 Kategori
* [x] 10 Produk Cheap N Use
* [x] Tabel tambahan: user_balances, store_balances, virtual_accounts

## ✔ Tantangan Khusus (Challenge)

### *1. Role Based Access Control (RBAC)*

* [x] Admin hanya akses halaman admin
* [x] Seller akses dashboard seller (harus role member + punya store)
* [x] Member akses halaman customer
* [x] Middleware role + isSeller

### *2. Sistem Keuangan: Wallet & Virtual Account*

* [x] Tabel user_balances
* [x] Topup wallet via VA unik
* [x] Pembayaran checkout via VA unik
* [x] Validasi nominal dan transaksi

### *3. Dedicated Payment Page*

* [x] Input kode VA
* [x] Tampilkan detail pembayaran
* [x] Input nominal transfer (simulasi)
* [x] Update saldo / pembayaran transaksi

---

# 🏗 Deskripsi Proyek

Aplikasi *Cheap N Use* merupakan platform e-commerce sederhana berbasis Laravel dengan:

* Sistem toko/penjual
* Sistem transaksi & checkout
* Pembayaran via *Wallet* atau *Transfer VA*
* Dashboard untuk Customer, Seller, dan Admin

Produk utama yang dijual berasal dari brand *Cheap N Use*, terdiri dari pakaian, tas, sepatu, dan aksesoris dengan harga terjangkau.

---

# 🛠 Teknologi yang Digunakan

* Laravel 12
* PHP 8
* MySQL
* Laravel Breeze
* TailwindCSS + Vite
* Node.js

---

# 💳 Flow Pembayaran

## *A. Topup Wallet*

1. User mengajukan topup
2. VA unik digenerate
3. User masuk halaman pembayaran
4. Nominal divalidasi
5. Saldo user bertambah

## *B. Pembelian Langsung Menggunakan VA*

1. User checkout
2. Sistem membuat VA untuk transaksi
3. User membayar melalui halaman pembayaran
4. Status transaksi → paid
5. Saldo toko bertambah

---

# 📄 Fitur per Role

## I. Customer (dikerjakan Nashifa)

* Homepage + filter kategori
* Detail Produk
* Checkout (alamat, shipping, payment method)
* Riwayat transaksi
* Topup saldo wallet

---

## II. Seller Dashboard (dikerjakan Husna)

* Registrasi & edit toko
* Manajemen kategori
* Manajemen produk + gambar + thumbnail
* Pesanan masuk + update status
* Saldo toko
* Pengajuan withdrawal

---

## III. Admin Panel (dikerjakan Husna)

* Verifikasi toko
* Manajemen user
* Manajemen toko

---

# 🌱 Seeder

Seeder menghasilkan data awal:

* Admin
* 2 Member
* 1 Store
* 5 kategori produk Cheap N Use
* 10 produk Cheap N Use

Contoh Produk:

* Cheap N Use Hoodie
* Cheap N Use Tote Bag
* Cheap N Use Sneakers Budget Series
* Cheap N Use Basic T-Shirt
* Cheap N Use Travel Pouch

---

# ⚙ Cara Install & Menjalankan Proyek

bash
git clone <repo>
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
npm run dev


---

# 📁 Struktur Folder


app/
database/
public/
resources/
routes/
storage/
vendor/
README.md