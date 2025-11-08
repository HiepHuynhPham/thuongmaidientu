FROM php:8.2-fpm

# Cài Nginx và các thư viện PHP cần thiết (bao gồm PostgreSQL)
RUN apt-get update && apt-get install -y \
    nginx libpng-dev libonig-dev libxml2-dev zip unzip git curl supervisor libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# Sao chép mã nguồn Laravel vào container
WORKDIR /var/www
COPY . .

# Cài Composer và các dependency Laravel
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader

# Copy file cấu hình Nginx
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Xóa site mặc định của Nginx
RUN rm -f /etc/nginx/sites-enabled/default

# Copy file cấu hình Supervisor
RUN mkdir -p /etc/supervisor/conf.d
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Phân quyền cho Laravel
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Mở cổng 80
EXPOSE 80

# Chạy migrate khi container khởi động


# Chạy Supervisor để giữ container sống
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
