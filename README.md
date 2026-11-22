# Garuda-Hub

Website lelang proyek IT: klien memasang proyek, developer menawar, klien memilih pemenang. Dibuat untuk **studi kasus pembelajaran keamanan** mahasiswa dengan praktik PHP standar. Semua data adalah data dummy.

## PERINGATAN

- **Hanya untuk komputer lokal atau lingkungan belajar.** Jangan dipasang di server publik atau internet.
- Konfigurasi bawaan memakai database `root` dengan password kosong. Itu hanya aman di komputer lokal.
- Tidak ada pembatasan percobaan login (rate limit).
- Tidak ada header keamanan `X-Frame-Options` maupun `Content-Security-Policy`.
- Jangan memasukkan data pribadi atau password asli.

## Fitur

- Daftar dan login dengan peran klien, developer, admin
- Klien memasang proyek (judul, deskripsi, kategori, budget, batas lelang)
- Daftar, pencarian, dan detail proyek beserta penawaran
- Developer mengajukan penawaran (harga, durasi, proposal)
- Klien memilih pemenang
- Dasbor per peran dan panel admin

## Kebutuhan

- PHP 8.1 atau lebih baru dengan ekstensi `mysqli`
- MySQL atau MariaDB

## Instalasi

1. Klon repositori ini lalu masuk ke foldernya.
2. Impor skema dan data dummy:
   ```
   mysql -u root -p < legacy-src/database.sql
   ```
   Ini membuat database `garuda_hub` dan **menghapus** tabel `users`, `projects`, `bids` jika sudah ada.
3. (Opsional) Atur koneksi database lewat variabel lingkungan:

   | Variabel | Bawaan |
   | --- | --- |
   | `GH_DB_HOST` | `127.0.0.1` |
   | `GH_DB_USER` | `root` |
   | `GH_DB_PASS` | kosong |
   | `GH_DB_NAME` | `garuda_hub` |
   | `GH_DB_PORT` | `3306` |

   Contoh: `export GH_DB_USER=nama_pengguna_anda`
4. Jalankan server bawaan PHP:
   ```
   php -S localhost:8000 -t legacy-src
   ```
5. Buka `http://localhost:8000`.

## Akun dummy

Data awal berisi akun fiktif berdomain `example.com`: satu admin (`admin@example.com`), klien (`budi@`, `siti@`, `agus@`), dan developer (`dewi@`, `eko@`, `fitri@`, `gilang@`). Password tidak dicantumkan di sini. Anda dapat mendaftar akun baru sebagai klien atau developer lewat halaman Daftar.

## Struktur

- `legacy-src/index.php`: seluruh aplikasi (routing lewat `?page=`)
- `legacy-src/database.sql`: skema dan data dummy

## Panduan pemakaian

Lihat folder `docs/user/` bila tersedia.

## Lisensi

MIT. Lihat [LICENSE](LICENSE).

## Garuda-Hub (Versi Laravel)

Refactoring dari PHP Native (spaghetti code) ke Laravel dengan arsitektur MVC dan Eloquent ORM.

### Kebutuhan (Versi Laravel)

- PHP 8.3 atau lebih baru dengan ekstensi `pdo_mysql`
- Composer
- Node.js 20.19 atau lebih baru dan npm
- MySQL atau MariaDB

### Skema Database

- `users` (id, name, email, password, role: client/developer/admin)
- `projects` (id, client_id -> users, title, description, category, budget, bid_deadline, status, winning_bid_id -> bids)
- `bids` (id, project_id -> projects, developer_id -> users, price, duration_days, proposal, status; unik per project_id + developer_id)

### Fitur

- Autentikasi (Laravel Breeze) dengan peran Klien dan Developer
- CRUD proyek oleh klien
- Developer mengajukan penawaran (satu penawaran per proyek)
- Klien memilih pemenang (transaksi database)

### Cara Menjalankan

1. Buat database kosong bernama `garuda_hub_laravel` (misalnya lewat phpMyAdmin).
2. Jalankan perintah berikut:

        cd laravel-app
        composer install
        copy .env.example .env
        php artisan key:generate

3. Buka file `.env`, lalu atur bagian database seperti ini (hapus tanda `#` di depan baris yang diawali `#` jika ada):

        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=garuda_hub_laravel
        DB_USERNAME=root
        DB_PASSWORD=

   Sesuaikan `DB_USERNAME` dan `DB_PASSWORD` dengan pengaturan MySQL kamu.
4. Lanjutkan:

        php artisan migrate --seed
        npm install
        npm run build
        php artisan serve

Akun admin dari seeder: `admin@example.com` / `password`

Kode lama (PHP Native) disimpan di folder `legacy-src` sebagai referensi.