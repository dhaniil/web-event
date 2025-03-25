
# Panduan Deployment Event Stembayo

Dokumen ini berisi panduan lengkap untuk menginstal dan men-deploy aplikasi Event Stembayo.

## Daftar Isi
1. [Prasyarat Sistem](#prasyarat-sistem)
2. [Instalasi Development](#instalasi-development)
3. [Deployment Production](#deployment-production)
4. [Konfigurasi](#konfigurasi)
5. [Troubleshooting](#troubleshooting)
6. [Maintenance](#maintenance)

## Prasyarat Sistem

### Software Requirements
- PHP >= 8.1
  - Ekstensi: BCMath, Ctype, JSON, Mbstring, OpenSSL, PDO, XML
  - Memory limit >= 128MB
- MySQL >= 8.0
- Node.js >= 16.x
- NPM >= 8.x
- Composer >= 2.0
- Git

### Server Requirements (Production)
- Nginx/Apache
- SSL Certificate
- RAM minimal 2GB
- Storage minimal 20GB
- CPU minimal 2 cores

## Instalasi Development

### 1. Clone Repository
```bash
git clone https://github.com/dhaniil/web-event.git
cd event-stembayo
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Konfigurasi Environment
```bash
# Copy file environment
cp .env.example .env

# Generate app key
php artisan key:generate

# Edit konfigurasi database di .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=event
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Setup Database
```bash
# Jalankan migrasi
php artisan migrate

# Jalankan seeder (opsional)
php artisan db:seed
```

### 5. Setup Storage
```bash
# Link storage
php artisan storage:link

# Set permission (Linux/Mac)
chmod -R 775 storage bootstrap/cache
chown -R $USER:www-data storage bootstrap/cache
```

### 6. Build Assets
```bash
# Development
npm run dev

# Production
npm run build
```

## Deployment Production

### 1. Persiapan Server
```bash
# Update sistem
sudo apt update && sudo apt upgrade

# Install software yang diperlukan
sudo apt install nginx mysql-server php8.1-fpm php8.1-mysql
sudo apt install php8.1-bcmath php8.1-xml php8.1-mbstring php8.1-zip
```

### 2. Konfigurasi Nginx
```nginx
server {
    listen 80;
    server_name event.stembayo.sch.id;
    root /var/www/event-stembayo/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### 3. Deploy Code
```bash
# Di server production
cd /var/www/event-stembayo

# Pull code terbaru
git pull origin main

# Install dependencies
composer install --no-dev
npm install
npm run build

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Migrasi database
php artisan migrate --force

# Set permission
chown -R www-data:www-data *
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
```

## Konfigurasi

### Mail
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@stembayo.sch.id
MAIL_FROM_NAME="${APP_NAME}"
```

### File Upload
```env
# .env
FILESYSTEM_DISK=public
```

### Queue
```bash
# Install supervisor
sudo apt install supervisor

# Buat konfigurasi queue
sudo nano /etc/supervisor/conf.d/event-stembayo-worker.conf

[program:event-stembayo-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/event-stembayo/artisan queue:work
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/event-stembayo/storage/logs/worker.log
```

## Troubleshooting

### Permission Issues
```bash
# Reset permission
sudo chown -R www-data:www-data /var/www/event-stembayo
sudo find /var/www/event-stembayo -type f -exec chmod 644 {} \;
sudo find /var/www/event-stembayo -type d -exec chmod 755 {} \;
```

### Storage Issues
```bash
# Recreate storage link
php artisan storage:link
```

### Database Issues
```bash
# Reset database
php artisan migrate:fresh --seed
```

## Maintenance

### Backup
```bash
# Backup database
mysqldump -u root -p event_stembayo > backup_$(date +%Y%m%d).sql

# Backup files
tar -czf backup_$(date +%Y%m%d).tar.gz /var/www/event-stembayo
```

### Update
```bash
# Update dependencies
composer update
npm update

# Clear cache
php artisan optimize:clear

# Migrasi database
php artisan migrate

# Build assets
npm run build
```

### Monitoring
- Gunakan Laravel Telescope untuk debug di development
- Setup logging ke external service (contoh: Papertrail)
- Monitoring server dengan Supervisor
- Health check endpoint

### Security
- Selalu update dependencies
- Backup rutin
- SSL certificate update
- File permission yang tepat
- Firewall configuration
- Rate limiting
