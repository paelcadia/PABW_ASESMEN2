# SmartFacility

Aplikasi pelaporan kerusakan Donasis kampus berbasis Laravel 12, MySQL, dan HMVC. Mahasiswa dapat melihat Donasis dan mengirim Pengajuan; admin dapat mengelola Donasis serta memproses status Pengajuan.

## Persyaratan

- PHP 8.3 atau lebih baru
- Composer
- MySQL/MariaDB
- Node.js dan npm

## Instalasi dan Menjalankan Aplikasi

1. Buat database MySQL:

   ```sql
   CREATE DATABASE foodshare CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

2. Salin `.env.example` menjadi `.env`, lalu sesuaikan konfigurasi database:

   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=smartfacility
   DB_USERNAME=root
   DB_PASSWORD=
   ```

3. Dari folder project, jalankan:

   ```bash
   composer install
   composer dump-autoload
   php artisan key:generate
   php artisan migrate
   php artisan module:migrate --all
   php artisan db:seed
   php artisan storage:link
   npm.cmd install
   npm.cmd run dev
   ```

   Perintah `npm.cmd` dapat digunakan pada PowerShell Windows jika `npm` diblokir oleh Execution Policy. Untuk build aset produksi, gunakan `npm.cmd run build` sebagai pengganti `npm.cmd run dev`.

4. Buka terminal kedua dan jalankan server Laravel:

   ```bash
   php artisan serve
   ```

5. Buka `http://127.0.0.1:8000`.

Migrasi Laravel utama dijalankan dengan `php artisan migrate`. Migrasi semua modul HMVC dijalankan dengan `php artisan module:migrate --all`. Jika migrasi modul sudah pernah tercatat, perintah tersebut tidak membuat tabel duplikat.

## Akun Demo

- **Admin:** `admin@foodshare.local`
- **Password:** `password`

Seeder membuat akun admin dan contoh data Donasis. Registrasi dari aplikasi selalu membuat akun ber-role `pemohon`. Ganti password demo sebelum aplikasi digunakan pada lingkungan produksi.