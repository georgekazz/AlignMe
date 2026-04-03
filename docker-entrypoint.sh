#!/bin/bash

echo "Waiting for database..."

# Wait until MySQL is actually ready
until php -r "new PDO('mysql:host=db;port=3306;dbname=laravel', 'root', 'root');" 2>/dev/null; do
    echo "Database not ready, retrying in 3s..."
    sleep 3
done

echo "Database is ready!"

# Εκτέλεση των Laravel migrations & seeding
php artisan migrate --force

SEED_COUNT=$(php artisan tinker --execute='echo \App\Models\User::count();' 2>/dev/null | tr -d '[:space:]')

if [ "$SEED_COUNT" -eq "0" ]; then
    echo "Seeding database..."
    php artisan db:seed --force
else
    echo "Database already seeded. Skipping..."
fi

# Εκκίνηση Apache
exec apache2-foreground