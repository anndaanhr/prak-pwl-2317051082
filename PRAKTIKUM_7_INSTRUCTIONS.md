# Instruksi Praktikum 7 - Laravel Breeze Authentication

## Yang Sudah Dilakukan:
1. ✅ Branch `auth-authorization` telah dibuat dari branch `dev` dan di-push ke GitHub
2. ✅ Laravel Breeze telah ditambahkan ke `composer.json`

## Langkah-langkah yang Perlu Dijalankan:

**CATATAN**: Pastikan PHP sudah ada di PATH environment variable Windows Anda sebelum menjalankan perintah-perintah berikut.

### 1. Install Laravel Breeze Package
Jalankan perintah berikut di terminal (pastikan PHP sudah ada di PATH):
```bash
composer require laravel/breeze --dev
```
Atau jika sudah ditambahkan ke composer.json, jalankan:
```bash
composer install
```

### 2. Inisialisasi Laravel Breeze
Jalankan perintah berikut:
```bash
php artisan breeze:install
```

**Ketika diminta pilihan:**
- Pilih: `blade` (untuk Blade With Alpine)
- Dark mode: `yes`
- Testing framework: `1` (untuk PHPUnit)

### 3. Setup Database
Jalankan migrate fresh untuk membuat tabel authentication:
```bash
php artisan migrate:fresh
```

### 4. Install NPM Dependencies (jika belum)
```bash
npm install
```

### 5. Build Assets
```bash
npm run build
```
atau untuk development:
```bash
npm run dev
```

### 6. Jalankan Server
```bash
php artisan serve
```

### 7. Test Authentication
1. Buka browser dan akses: `http://localhost:8000`
2. Klik tombol "Register" untuk membuat akun baru
3. Setelah registrasi, login dengan kredensial yang dibuat
4. Verifikasi di database bahwa data user sudah tersimpan dengan password yang ter-hash

## Catatan:
- Pastikan Node.js sudah terinstall (download dari https://nodejs.org/id)
- Pastikan PHP sudah ada di PATH environment variable
- Pastikan database sudah dikonfigurasi di file `.env`

