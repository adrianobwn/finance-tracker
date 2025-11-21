# 💰 FinanceFlow - Personal Finance Tracker

Aplikasi manajemen keuangan pribadi berbasis web yang membantu Anda melacak pemasukan, pengeluaran, dan mengatur anggaran dengan mudah.

## ✨ Fitur Utama

- 📊 **Dashboard Interaktif** - Visualisasi keuangan dengan grafik real-time
- 💵 **Manajemen Transaksi** - Catat pemasukan dan pengeluaran dengan mudah
- 📁 **Kategori Fleksibel** - 28+ kategori default (dapat disesuaikan)
- 🎯 **Budget Tracking** - Atur dan monitor anggaran bulanan/mingguan/tahunan
- 📈 **Laporan Keuangan** - Analisis keuangan dengan breakdown kategori
- 👥 **Multi-User** - Support user dan admin role
- 🔐 **Authentication** - Sistem login & registrasi yang aman
- 📱 **Responsive Design** - Tampil sempurna di desktop dan mobile

## 🛠️ Tech Stack

- **Framework**: Laravel 12.x
- **Frontend**: Blade Templates, TailwindCSS
- **Database**: MySQL
- **Charts**: Chart.js
- **Icons**: Font Awesome

## 📋 Requirements

- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js & NPM

## 🚀 Installation

1. **Clone Repository**
```bash
git clone https://github.com/adrianobwn/finance-tracker.git
cd finance-tracker
```

2. **Install Dependencies**
```bash
composer install
npm install
```

3. **Environment Setup**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Database Configuration**
Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=finance_tracker
DB_USERNAME=root
DB_PASSWORD=
```

5. **Create Database**
```bash
mysql -u root -e "CREATE DATABASE finance_tracker"
```

6. **Run Migrations & Seeders**
```bash
php artisan migrate --seed
```

7. **Compile Assets**
```bash
npm run build
```

8. **Start Server**
```bash
php artisan serve
```

Akses aplikasi di: `http://127.0.0.1:8000`

## 👤 Default Users

Setelah seeding, Anda dapat login dengan:

**Admin:**
- Email: admin@finance.com
- Password: password

**User:**
- Email: user@finance.com
- Password: password

## 📁 Project Structure

```
finance-tracker/
├── app/
│   ├── Enums/          # Transaction & User role enums
│   ├── Http/
│   │   └── Controllers/
│   ├── Models/
│   └── Services/       # Business logic layer
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/          # Blade templates
├── routes/
│   └── web.php
└── public/
```

## 🎯 Main Features Detail

### 1. Dashboard
- Total saldo, pemasukan, dan pengeluaran
- Grafik trend 6 bulan terakhir (atau berdasarkan filter tanggal)
- Filter berdasarkan tanggal
- Transaksi terbaru
- Peringatan budget

### 2. Transaksi
- CRUD transaksi (Create, Read, Update, Delete)
- Filter berdasarkan tipe (income/expense) dan kategori
- Upload bukti transaksi
- Pencarian dan pagination

### 3. Anggaran (Budget)
- Buat anggaran per kategori atau global
- Monitor pengeluaran vs anggaran
- Alert jika mendekati limit
- Periode: mingguan, bulanan, tahunan

### 4. Laporan
- Laporan bulanan per tahun
- Breakdown pengeluaran per kategori
- Export data (future feature)

### 5. Admin Panel
- User management (CRUD users)
- View semua transaksi semua user
- Dashboard overview untuk semua user

## 🔐 User Roles

**Admin:**
- Akses ke semua fitur
- Dapat melihat data semua user
- User management

**User:**
- Hanya dapat melihat data pribadi
- Manage transaksi & budget sendiri

## 🎨 Customization

### Menambah Kategori
Edit file `database/seeders/CategorySeeder.php` atau buat lewat aplikasi.

### Mengubah Currency
Default: IDR. Dapat diubah per user di database atau tambahkan fitur settings.

## 📝 License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👨‍💻 Developer

Developed by [Adriano Bawan](https://github.com/adrianobwn)

---

**Note:** Aplikasi ini dibuat untuk tujuan pembelajaran dan portfolio project.
