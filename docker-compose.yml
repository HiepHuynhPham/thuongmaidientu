FROM php:8.2-fpm

# Cài Nginx, PHP extensions, và các thư viện cần thiết
RUN apt-get update && apt-get install -y \
    nginx libpng-dev libonig-dev libxml2-dev zip unzip git curl supervisor libzip-dev default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Sao chép mã nguồn Laravel
WORKDIR /var/www
COPY . .

# Cài Composer và dependency Laravel
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader

# Copy cấu hình Nginx
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Copy cấu hình Supervisor
RUN mkdir -p /etc/supervisor/conf.d
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Phân quyền cho Laravel
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Mở port 80
EXPOSE 80

# Chạy bằng Supervisor (Nginx + PHP-FPM)
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
