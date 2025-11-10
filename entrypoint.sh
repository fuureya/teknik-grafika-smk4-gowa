#!/bin/sh
set -e

# Permission fix
if [ -d "/var/www/html/storage" ]; then
    chmod -R 755 /var/www/html/storage
    chown -R nginx:nginx /var/www/html/storage
fi

if [ -d "/var/www/html/bootstrap/cache" ]; then
    chmod -R 755 /var/www/html/bootstrap/cache
    chown -R nginx:nginx /var/www/html/bootstrap/cache
fi

# Composer install
if [ -f "/var/www/html/composer.json" ]; then
    composer install --no-dev --optimize-autoloader --no-interaction
fi

# Copy .env jika belum ada
if [ -f "/var/www/html/.env.example" ] && [ ! -f "/var/www/html/.env" ]; then
    cp /var/www/html/.env.example /var/www/html/.env
fi

# Laravel artisan commands
if [ -f "/var/www/html/artisan" ]; then
    # Jangan generate key lagi kalau APP_KEY sudah ada
    if ! grep -q "APP_KEY=" /var/www/html/.env; then
        php /var/www/html/artisan key:generate --force
    fi

    # Migrasi biasa (tidak hapus data)
    php /var/www/html/artisan migrate --force

    # Storage link tanpa prompt
    php /var/www/html/artisan storage:link --force

    # Cache commands
    php /var/www/html/artisan config:cache
    php /var/www/html/artisan route:cache
    php /var/www/html/artisan view:cache
fi

# NPM build
if [ -f "/var/www/html/package.json" ]; then
    npm ci
    npm run build
    rm -rf node_modules
fi

chown -R nginx:nginx /var/www/html
find /var/www/html -type f -exec chmod 644 {} \;
find /var/www/html -type d -exec chmod 755 {} \;

# Jalankan php-fpm & nginx
php-fpm84 -D
exec nginx -g "daemon off;"