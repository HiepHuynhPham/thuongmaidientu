FROM php:8.0-fpm

# Cài Nginx và các thư viện PHP cần thiết
RUN apt-get update && apt-get install -y nginx libpng-dev libonig-dev libxml2-dev zip unzip git curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Sao chép mã nguồn
WORKDIR /var/www
COPY . .

# Cài Composer và Laravel dependencies
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --prefer-dist

# Copy file cấu hình Nginx
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Phân quyền
RUN chown -R www-data:www-data /var/www && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Mở cổng web
EXPOSE 80

# Chạy cả Nginx và PHP-FPM
CMD service nginx start && php-fpm
