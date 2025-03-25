# Event Stembayo 🎉

Sistem Manajemen Event untuk SMKN 2 Depok Sleman. Platform ini memungkinkan sekolah untuk mengelola, mempublikasikan, dan melacak berbagai event yang diselenggarakan oleh sekolah.

![Screenshot Event Stembayo](screenshot.png)

## 🌟 Fitur Utama

- **Manajemen Event**
  - Posting event baru dengan informasi lengkap
  - Upload gambar event
  - Pengelolaan kategori event
  - Status event (upcoming, ongoing, finished)

- **User Experience**
  - Pencarian dan filter event
  - Favorite event
  - Review dan rating
  - Notifikasi event

- **Admin Dashboard**
  - Manajemen user
  - Analitik event
  - Moderasi konten
  - Event banner management

## 🛠 Teknologi

- **Backend**: Laravel 10.x
- **Frontend**: 
  - Bootstrap 5
  - Alpine.js
  - Tailwind CSS
- **Database**: MySQL
- **Additional**:
  - Laravel Filament (Admin Panel)
  - Laravel Scout (Search)
  - Spatie Activity Log
  - Laravel Permission

## 🚀 Mulai Cepat

```bash
# Clone repository
git clone https://github.com/username/event-stembayo.git

# Pindah ke direktori proyek
cd event-stembayo

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Migrasi database
php artisan migrate

# Compile assets
npm run dev

# Jalankan server
php artisan serve
```

Untuk panduan lengkap instalasi dan deployment, silakan lihat [DEPLOY.md](DEPLOY.md)

## 📁 Struktur Proyek

```
event-stembayo/
├── app/                # Logika aplikasi
│   ├── Http/          # Controllers, Middleware
│   ├── Models/        # Model database
│   └── Providers/     # Service providers
├── config/            # Konfigurasi aplikasi
├── database/          # Migrasi dan seeds
├── public/            # Asset publik
├── resources/         # Views dan asset
└── routes/            # Definisi route
```

## 🔧 Prasyarat Sistem

- PHP >= 8.1
- Node.js >= 16.x
- MySQL >= 8.0
- Composer
- NPM

## 🤝 Kontribusi

Kami sangat menghargai kontribusi dari komunitas. Jika Anda ingin berkontribusi:

1. Fork repository
2. Buat branch fitur (`git checkout -b fitur-keren`)
3. Commit perubahan (`git commit -am 'Menambahkan fitur keren'`)
4. Push ke branch (`git push origin fitur-keren`)
5. Buat Pull Request

## 📝 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE)

## 👥 Tim Pengembang

- UI/UX Designer: Farcha Amalia Nugrahaini
- Backend Developer: Ahmad Hanaffi Rahmadhani
- Frontend Developer: Laurentius Daviano Maximus Antara

---

