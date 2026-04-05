#!/bin/bash

echo "Waiting for database..."

# Override .env with container environment variables
sed -i "s/DB_HOST=.*/DB_HOST=${DB_HOST}/" /var/www/html/.env
sed -i "s/DB_DATABASE=.*/DB_DATABASE=${DB_DATABASE}/" /var/www/html/.env
sed -i "s/DB_USERNAME=.*/DB_USERNAME=${DB_USERNAME}/" /var/www/html/.env
sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=${DB_PASSWORD}/" /var/www/html/.env

# Wait until MySQL is actually ready
until php -r "new PDO('mysql:host=${DB_HOST};port=${DB_PORT};dbname=${DB_DATABASE}', '${DB_USERNAME}', '${DB_PASSWORD}');" 2>/dev/null; do
    echo "Database not ready, retrying in 3s..."
    sleep 3
done

echo "Database is ready!"

php artisan migrate --force

SEED_COUNT=$(php artisan tinker --execute='echo \App\Models\User::count();' 2>/dev/null | tr -d '[:space:]')

if [ "$SEED_COUNT" -eq "0" ]; then
    echo "Seeding database..."
    php artisan db:seed --force
else
    echo "Database already seeded. Skipping..."
fi

exec apache2-foreground
