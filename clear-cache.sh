#!/bin/bash

# Clear Laravel caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

# Clear Composer cache
composer dump-autoload

# Clear NPM and rebuild
rm -rf node_modules
rm package-lock.json
npm install
npm run build

# Fix permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Restart PHP-FPM (adjust for your system)
sudo systemctl restart php8.2-fpm
