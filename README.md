# Bursa Event Sekolah

## Prerequisites
- PHP 8.2+
- Node.js 18+
- Composer
- MySQL/SQLite

## Installation Steps

1. Clone repository
```bash
git clone https://github.com/username/bursa-event-sekolah.git
cd bursa-event-sekolah
```

2. Install dependencies
```bash
composer install
npm install
```

3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
php artisan storage:link
```

4. Configure database in .env
For MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=username_database
DB_PASSWORD=password_database
```

Or for SQLite:
```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite
```
Then create SQLite database:
```bash
touch database/database.sqlite
```

5. Run migrations and seeders
```bash
php artisan migrate
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=SuperAdminSeeder
```

6. Build assets
```bash
# For development
npm run dev

# For production
npm run build
```

7. Start development server
```bash
php artisan serve
```

Visit http://localhost:8000 to access the application.

## Team

- UI/UX: Farcha Amalia Nugrahaini (Limleye)
- Front-End: Laurentius Daviano Maximus Antara (LmX)
- Back-End: Ahmad Hanaffi Rahmadhani (iLazer)

## License

[MIT License](LICENSE)
