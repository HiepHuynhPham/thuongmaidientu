#!/usr/bin/env bash
set -e
echo "Running Laravel deploy steps..."

composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan migrate --force

# Build frontend assets
npm ci || npm install
npm run build

# Clear caches
php artisan config:clear
php artisan cache:clear

echo "Deploy complete."