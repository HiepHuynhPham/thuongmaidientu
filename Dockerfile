FROM php:8.2-fpm

# CA�i Nginx vA� cA�c th�� vi���n PHP c��n thi���t (bao g��"m PostgreSQL)
RUN apt-get update && apt-get install -y \
    nginx libpng-dev libonig-dev libxml2-dev zip unzip git curl supervisor libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# Sao chAcp mA� ngu��"n Laravel vA�o container
WORKDIR /var/www
COPY . .

# CA�i Composer vA� cA�c dependency Laravel
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader

# -------------------------------
# FIX STORAGE FOR IMAGES
# -------------------------------
RUN php artisan storage:link || true
RUN chmod -R 777 /var/www/storage /var/www/bootstrap/cache

# Copy file c���u hA�nh Nginx
COPY nginx.conf /etc/nginx/conf.d/default.conf

# XA3a site m���c �`��<nh c��a Nginx
RUN rm -f /etc/nginx/sites-enabled/default

# Copy file c���u hA�nh Supervisor
RUN mkdir -p /etc/supervisor/conf.d
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# PhA�n quy��?n cho Laravel
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# M��Y c��ng 80
EXPOSE 80

# Ch���y migrate khi container kh��Yi �`��Tng


# Ch���y Supervisor �`��� gi��_ container s��`ng
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
