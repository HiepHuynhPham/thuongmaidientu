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
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Tạo file .env từ .env.example (nếu có)
RUN cp .env.example .env || true

# Tạo key cho Laravel (Render sẽ có APP_KEY trong env, nhưng phòng khi thiếu)
RUN php artisan key:generate || true

# Set quyền cho Laravel
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Expose cổng 80 (Laravel chạy qua php-fpm)
EXPOSE 80

CMD ["php-fpm"]
