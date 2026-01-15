FROM php:8.2-apache

# Cài PostgreSQL driver cho PHP (BẮT BUỘC)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql pgsql

# Enable Apache rewrite (nếu dùng .htaccess / routing)
RUN a2enmod rewrite

# Copy source code vào Apache web root
COPY . /var/www/html/

# Set quyền
RUN chown -R www-data:www-data /var/www/html
