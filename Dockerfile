FROM php:8.0-fpm

# Cài extension PHP và các tool cần thiết
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip git curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Đặt thư mục làm việc
WORKDIR /var/www

# Copy mã nguồn Laravel vào container
COPY . .

# Cài các dependency Laravel
RUN composer install --no-interaction --prefer-dist

# Set quyền cho Laravel
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Expose cổng 80 cho php artisan serve
EXPOSE 80

COPY .env .env

