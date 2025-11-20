# Finance Tracker - Panduan Instalasi

## Langkah-langkah Setup untuk Teman/Developer Lain

### 1. Clone Repository
```bash
git clone <repository-url>
cd finance-tracker
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database
Edit file `.env` dan sesuaikan dengan database MySQL Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=finance-tracker
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Buat Database
Buat database baru di MySQL:
```sql
CREATE DATABASE finance_tracker;
```

### 6. Run Migration & Seeder
```bash
php artisan migrate:fresh --seed
```

**PENTING:** Command ini akan:
- Membuat semua tabel termasuk kolom `currency` di tabel `users`
- Membuat 2 user default:
  - Admin: `admin@finance.com` / `password`
  - User: `user@finance.com` / `password`
- Membuat 29 kategori default
- Membuat beberapa transaksi sample

### 7. Refresh Composer Autoload
```bash
composer dump-autoload
```

**PENTING:** Command ini memuat helper functions untuk currency:
- `currency_symbol()` - mendapatkan simbol mata uang
- `format_currency()` - format angka dengan mata uang

### 8. Compile Assets
```bash
npm run dev
# atau untuk production:
npm run build
```

### 9. Jalankan Server
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://127.0.0.1:8000`

---

## Troubleshooting

### Error: "Call to undefined function currency_symbol()"
**Solusi:**
```bash
composer dump-autoload
```

### Error: "Unknown column 'currency' in users table"
**Solusi:**
```bash
php artisan migrate:fresh --seed
```

### Error setelah git pull
**Solusi:**
```bash
composer install
composer dump-autoload
php artisan migrate
php artisan config:clear
php artisan cache:clear
```

---

## Fitur Mata Uang

Aplikasi mendukung 7 mata uang:
- **IDR** - Rupiah (Rp)
- **USD** - US Dollar ($)
- **EUR** - Euro (€)
- **GBP** - British Pound (£)
- **JPY** - Japanese Yen (¥)
- **SGD** - Singapore Dollar (S$)
- **MYR** - Malaysian Ringgit (RM)

Untuk mengganti mata uang:
1. Login ke aplikasi
2. Buka menu **Pengaturan**
3. Pilih mata uang dari dropdown
4. Sistem akan otomatis mengupdate semua tampilan

---

## Akun Default

### Admin
- Email: `admin@finance.com`
- Password: `password`
- Akses: Dashboard Admin, User Management

### User
- Email: `user@finance.com`
- Password: `password`
- Akses: Dashboard, Transaksi, Anggaran, Laporan, Pengaturan

---

## Tech Stack
- Laravel 12.x
- PHP 8.4+
- MySQL 8.0+
- Tailwind CSS
- Chart.js
- Font Awesome 6.4.0
