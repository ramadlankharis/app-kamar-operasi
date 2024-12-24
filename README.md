---

# Panduan Menjalankan Aplikasi Laravel Secara Lokal

Panduan ini membantu Anda menjalankan aplikasi Laravel pada lingkungan lokal. Ikuti langkah-langkah berikut.

## Lingkungan Aplikasi

- **PHP**: Versi 8.3
- **Node.js**: Versi 20.11

---

## Menjalankan Secara Lokal

### 1. Clone Proyek

Clone repositori proyek ke komputer Anda.

```bash
git clone https://link-to-project
```

### 2. Masuk ke Direktori Proyek

Pindah ke direktori proyek yang telah di-clone.

```bash
cd my-project
```

### 3. Install Dependency Composer

Unduh semua dependensi PHP yang diperlukan.

```bash
composer install
```

### 4. Install Dependency Node.js

Unduh semua dependensi frontend yang diperlukan.

```bash
npm install
```

### 5. Salin dan Konfigurasi File `.env`

-   Salin file `.env.example` menjadi `.env`.

```bash
cp .env.example .env
```

-   Edit file `.env` sesuai konfigurasi aplikasi Anda (seperti pengaturan database).

### 6. Cache Konfigurasi

Cache konfigurasi Laravel agar lebih cepat diakses.

```bash
php artisan config:cache
```

### 7. Jalankan Migrasi Database

Buat tabel database sesuai dengan migrasi yang tersedia.

```bash
php artisan migrate
```

### 8. Generate Application Key

Generate application key untuk keamanan aplikasi.

```bash
php artisan key:generate
```

### 9. Install Reverb (Opsional)

Jika aplikasi menggunakan fitur `Reverb`, instal dengan perintah berikut dan pilih `yes` saat diminta.

```bash
php artisan reverb:install
```

### 10. Cache Ulang Konfigurasi (Opsional)

Cache ulang konfigurasi setelah instalasi `Reverb`.

```bash
php artisan config:cache
```

---

## Menjalankan Aplikasi

### 1. Menjalankan Server Laravel

Gunakan perintah berikut untuk menjalankan server Laravel.

```bash
php artisan serve
```

Akses aplikasi melalui browser di [http://127.0.0.1:8000](http://127.0.0.1:8000).

### 2. Menjalankan Frontend (Vite)

Jalankan proses build frontend menggunakan Vite.

```bash
npm run dev
```

### 3. Menjalankan Reverb (Jika Ada)

Jalankan `Reverb` dengan mode debug.

```bash
php artisan reverb:start --debug
```

### 4. Menjalankan Queue Worker

Jalankan queue worker jika aplikasi menggunakan antrian.

```bash
php artisan queue:listen
```

---

## Catatan Penting untuk Pengguna Linux

Jika Anda menggunakan Linux:

-   Pastikan direktori `storage` memiliki izin yang sesuai.
-   Atur izin dengan perintah berikut:

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

---
