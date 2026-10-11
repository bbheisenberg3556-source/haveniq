#!/bin/sh
set -e

# Default PORT if not provided by Render (Render supplies $PORT, usually 10000)
export PORT=${PORT:-10000}
export DB_CONNECTION=${DB_CONNECTION:-sqlite}

echo "--> Initializing HavenIQ on port ${PORT}..."

# Check or generate APP_KEY if missing
if [ -z "$APP_KEY" ]; then
    echo "--> APP_KEY is empty. Generating temporary application key..."
    export APP_KEY=$(php /var/www/html/artisan key:generate --show)
fi

# Substitute $PORT into Nginx virtual host configuration
envsubst '${PORT}' < /var/www/html/docker/nginx.conf > /etc/nginx/http.d/default.conf

# Setup SQLite if DB_CONNECTION is sqlite
if [ "${DB_CONNECTION}" = "sqlite" ]; then
    mkdir -p /var/www/html/database
    if [ ! -f /var/www/html/database/database.sqlite ]; then
        touch /var/www/html/database/database.sqlite
        echo "--> Created SQLite database file."
    fi
    chown -R www-data:www-data /var/www/html/database
    chmod -R 775 /var/www/html/database
fi

# Ensure correct permissions on storage & cache
mkdir -p /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/framework/cache \
         /var/www/html/storage/logs \
         /var/www/html/storage/app/public/rooms

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Create storage symlink
php /var/www/html/artisan storage:link --force || true

# Run database migrations
echo "--> Running migrations..."
php /var/www/html/artisan migrate --force || true

# Optimize cache
echo "--> Optimizing configuration and routes..."
php /var/www/html/artisan config:cache || true
php /var/www/html/artisan route:cache || true
php /var/www/html/artisan view:cache || true

echo "--> Starting Nginx, PHP-FPM, and Queue Worker via Supervisord..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
