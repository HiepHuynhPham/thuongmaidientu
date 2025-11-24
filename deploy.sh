#!/usr/bin/env bash
set -e
echo "Running Laravel deploy steps..."

composer install --no-dev --optimize-autoloader
php artisan migrate --force

# Build frontend assets
npm ci || npm install
npm run build

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Ensure storage symlink for images
php artisan storage:link || true

echo "Deploy complete."